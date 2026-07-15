<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::with(['anggota', 'petugas']);
        
        if ($request->has('status')) {
            $query->where('status_peminjaman', $request->status);
        }
        if ($request->has('anggota')) {
            $query->where('id_anggota', $request->anggota);
        }

        return response()->json(['success' => true, 'message' => 'Data Peminjaman', 'data' => $query->paginate(10), 'errors' => null], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_peminjaman' => 'required|string|max:20|unique:peminjamans,kode_peminjaman',
            'id_anggota' => 'required|integer|exists:anggotas,id_anggota',
            'id_petugas' => 'required|integer|exists:petugas,id_petugas',
            'tanggal_pinjam' => 'required|date',
            'tanggal_batas_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'buku_ids' => 'required|array|min:1',
            'buku_ids.*' => 'required|integer|exists:bukus,id_buku'
        ]);

        try {
            DB::beginTransaction();

            $peminjaman = Peminjaman::create([
                'kode_peminjaman' => $validated['kode_peminjaman'],
                'id_anggota' => $validated['id_anggota'],
                'id_petugas' => $validated['id_petugas'],
                'tanggal_pinjam' => $validated['tanggal_pinjam'],
                'tanggal_batas_kembali' => $validated['tanggal_batas_kembali'],
                'status_peminjaman' => 'aktif',
                'total_buku' => count($validated['buku_ids'])
            ]);

            foreach ($validated['buku_ids'] as $id_buku) {
                $buku = Buku::lockForUpdate()->findOrFail($id_buku);
                if ($buku->stok_tersedia < 1) {
                    throw new \Exception("Buku ID {$id_buku} tidak tersedia (stok habis)");
                }

                $buku->decrement('stok_tersedia');

                DetailPeminjaman::create([
                    'id_peminjaman' => $peminjaman->id_peminjaman,
                    'id_buku' => $id_buku,
                    'status_buku' => 'dipinjam'
                ]);
            }

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Peminjaman berhasil', 'data' => $peminjaman->load('detailPeminjamans.buku'), 'errors' => null], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Peminjaman gagal', 'data' => null, 'errors' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $peminjaman = Peminjaman::with(['detailPeminjamans.buku', 'anggota', 'petugas'])->find($id);
        if (!$peminjaman) return response()->json(['success' => false, 'message' => 'Not found', 'data' => null, 'errors' => null], 404);
        return response()->json(['success' => true, 'message' => 'Detail Peminjaman', 'data' => $peminjaman, 'errors' => null], 200);
    }

    public function update(Request $request, $id)
    {
        $peminjaman = Peminjaman::find($id);
        if (!$peminjaman) return response()->json(['success' => false, 'message' => 'Not found', 'data' => null, 'errors' => null], 404);

        $validated = $request->validate([
            'status_peminjaman' => 'sometimes|string|max:20'
        ]);

        $peminjaman->update($validated);
        return response()->json(['success' => true, 'message' => 'Peminjaman diupdate', 'data' => $peminjaman, 'errors' => null], 200);
    }

    public function destroy($id)
    {
        $peminjaman = Peminjaman::find($id);
        if (!$peminjaman) return response()->json(['success' => false, 'message' => 'Not found', 'data' => null, 'errors' => null], 404);
        
        // Asumsi soft-delete atau cascade
        $peminjaman->delete();
        return response()->json(['success' => true, 'message' => 'Peminjaman dihapus', 'data' => null, 'errors' => null], 200);
    }
}
