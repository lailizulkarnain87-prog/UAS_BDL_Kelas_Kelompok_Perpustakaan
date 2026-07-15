<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Denda;
use App\Models\PembayaranDenda;
use App\Http\Requests\StorePembayaranDendaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembayaranDendaController extends Controller
{
    public function index($dendaId)
    {
        $denda = Denda::find($dendaId);
        if (!$denda) {
            return response()->json(['success' => false, 'message' => 'Denda tidak ditemukan', 'data' => null, 'errors' => null], 404);
        }

        $pembayaran = $denda->pembayaranDendas()->with('petugas')->get();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil data pembayaran',
            'data' => $pembayaran,
            'errors' => null
        ], 200);
    }

    public function store(StorePembayaranDendaRequest $request, $dendaId)
    {
        $denda = Denda::find($dendaId);
        if (!$denda) {
            return response()->json(['success' => false, 'message' => 'Denda tidak ditemukan', 'data' => null, 'errors' => null], 404);
        }

        $validated = $request->validated();
        
        // Pastikan id_denda pada payload validasi sama dengan parameter route
        if ($validated['id_denda'] != $denda->id) {
            return response()->json([
                'success' => false,
                'message' => 'ID Denda tidak valid atau tidak cocok',
                'data' => null,
                'errors' => ['id_denda' => ['ID Denda tidak cocok dengan rute']]
            ], 422);
        }

        try {
            DB::beginTransaction();
            
            // Re-fetch dengan Pessimistic Locking
            $denda = Denda::lockForUpdate()->findOrFail($dendaId);

            if ($denda->sisa_denda < $validated['jumlah_bayar']) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Jumlah bayar melebihi sisa denda',
                    'data' => null,
                    'errors' => ['jumlah_bayar' => ['Jumlah bayar melebihi sisa denda']]
                ], 422);
            }

            
            $pembayaran = PembayaranDenda::create($validated);

            $sisaBaru = $denda->sisa_denda - $validated['jumlah_bayar'];
            $statusLama = $denda->status_denda;
            $statusBaru = $sisaBaru <= 0 ? 'lunas' : $statusLama;

            $denda->update([
                'sisa_denda' => $sisaBaru,
                'status_denda' => $statusBaru
            ]);

            if ($statusLama !== $statusBaru) {
                \App\Models\RiwayatStatusDenda::create([
                    'id_denda' => $denda->id,
                    'status_sebelum' => $statusLama,
                    'status_sesudah' => $statusBaru,
                    'diubah_oleh' => $validated['id_petugas'] ?? auth('sanctum')->id(),
                    'alasan' => 'Pembayaran lunas'
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pembayaran berhasil',
                'data' => $pembayaran,
                'errors' => null
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Gagal memproses pembayaran', 'data' => null, 'errors' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $pembayaran = PembayaranDenda::with(['denda', 'petugas'])->find($id);
        if (!$pembayaran) {
            return response()->json(['success' => false, 'message' => 'Pembayaran tidak ditemukan', 'data' => null, 'errors' => null], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail pembayaran',
            'data' => $pembayaran,
            'errors' => null
        ], 200);
    }
}
