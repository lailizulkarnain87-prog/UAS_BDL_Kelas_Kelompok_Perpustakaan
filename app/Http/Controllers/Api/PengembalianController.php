<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pengembalian;
use App\Models\DetailPeminjaman;
use App\Models\Peminjaman;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PengembalianController extends Controller
{
    public function index()
    {
        $pengembalian = Pengembalian::with(['peminjaman', 'detailPeminjaman', 'petugas'])->paginate(10);
        return response()->json(['success' => true, 'message' => 'Data Pengembalian', 'data' => $pengembalian, 'errors' => null], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_detail' => 'required|integer|exists:detail_peminjamans,id_detail',
            'id_petugas' => 'required|integer|exists:petugas,id_petugas',
            'tanggal_kembali' => 'required|date',
            'kondisi_buku' => 'required|string|max:50',
            'keterangan' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            $detail = DetailPeminjaman::with(['peminjaman'])->lockForUpdate()->findOrFail($validated['id_detail']);
            $buku = Buku::lockForUpdate()->findOrFail($detail->id_buku);
            
            if ($detail->status_buku === 'dikembalikan') {
                throw new \Exception('Buku sudah dikembalikan sebelumnya');
            }

            $batasKembali = Carbon::parse($detail->peminjaman->tanggal_batas_kembali);
            $tglKembali = Carbon::parse($validated['tanggal_kembali']);
            
            $terlambatHari = 0;
            $denda = 0;

            if ($tglKembali->greaterThan($batasKembali)) {
                $terlambatHari = $batasKembali->diffInDays($tglKembali);
                $denda = $terlambatHari * 1000; // Misal denda Rp 1000/hari
            }

            $pengembalian = Pengembalian::create([
                'id_peminjaman' => $detail->id_peminjaman,
                'id_detail' => $detail->id_detail,
                'id_petugas' => $validated['id_petugas'],
                'tanggal_kembali' => $validated['tanggal_kembali'],
                'terlambat_hari' => $terlambatHari,
                'denda' => $denda,
                'kondisi_buku' => $validated['kondisi_buku'],
                'keterangan' => $validated['keterangan'] ?? null
            ]);

            // Update Stok Buku
            $buku->increment('stok_tersedia');
            
            // Update Status Detail Peminjaman
            $detail->update(['status_buku' => 'dikembalikan']);

            // Cek apakah semua buku dalam peminjaman ini sudah dikembalikan
            $belumKembali = DetailPeminjaman::where('id_peminjaman', $detail->id_peminjaman)
                ->where('status_buku', 'dipinjam')
                ->count();

            if ($belumKembali === 0) {
                $detail->peminjaman->update(['status_peminjaman' => 'selesai']);
            }

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Pengembalian berhasil', 'data' => $pengembalian, 'errors' => null], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Pengembalian gagal', 'data' => null, 'errors' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $pengembalian = Pengembalian::with(['peminjaman', 'detailPeminjaman', 'petugas'])->find($id);
        if (!$pengembalian) return response()->json(['success' => false, 'message' => 'Not found', 'data' => null, 'errors' => null], 404);
        return response()->json(['success' => true, 'message' => 'Detail Pengembalian', 'data' => $pengembalian, 'errors' => null], 200);
    }
}
