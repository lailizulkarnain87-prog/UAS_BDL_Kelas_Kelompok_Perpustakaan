<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Denda;
use App\Models\RiwayatStatusDenda;
use App\Http\Requests\StoreDendaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DendaController extends Controller
{
    public function index()
    {
        $dendas = Denda::with(['anggota', 'petugas'])->latest()->paginate(10);
        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil data denda',
            'data' => $dendas,
            'errors' => null
        ], 200);
    }

    public function store(StoreDendaRequest $request)
    {
        try {
            DB::beginTransaction();

            $denda = Denda::create($request->validated());

            RiwayatStatusDenda::create([
                'id_denda' => $denda->id,
                'status_sebelum' => '',
                'status_sesudah' => $denda->status_denda ?? 'pending',
                'diubah_oleh' => $denda->created_by,
                'alasan' => 'Denda baru dibuat'
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Denda berhasil dibuat',
                'data' => $denda,
                'errors' => null
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat denda',
                'data' => null,
                'errors' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $denda = Denda::with(['anggota', 'petugas', 'pembayaranDendas', 'riwayatStatusDendas'])->find($id);
        
        if (!$denda) {
            return response()->json([
                'success' => false,
                'message' => 'Denda tidak ditemukan',
                'data' => null,
                'errors' => null
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil detail denda',
            'data' => $denda,
            'errors' => null
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $denda = Denda::find($id);
        if (!$denda) {
            return response()->json(['success' => false, 'message' => 'Denda tidak ditemukan', 'data' => null, 'errors' => null], 404);
        }

        $validated = $request->validate([
            'total_denda' => 'sometimes|numeric|min:0',
            'sisa_denda' => 'sometimes|numeric|min:0',
            'status_denda' => 'sometimes|string|max:20',
            'tanggal_dikenakan' => 'sometimes|date',
            'tanggal_jatuh_tempo' => 'nullable|date|after_or_equal:tanggal_dikenakan',
            'alasan_denda' => 'nullable|string|max:1000',
        ]);

        try {
            DB::beginTransaction();
            $statusLama = $denda->status_denda;
            $denda->update($validated);

            if (isset($validated['status_denda']) && $validated['status_denda'] !== $statusLama) {
                RiwayatStatusDenda::create([
                    'id_denda' => $denda->id,
                    'status_sebelum' => $statusLama,
                    'status_sesudah' => $validated['status_denda'],
                    'diubah_oleh' => auth('sanctum')->id() ?? null,
                    'alasan' => 'Update data denda'
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Denda berhasil diupdate',
                'data' => $denda,
                'errors' => null
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Gagal update denda', 'data' => null, 'errors' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        $denda = Denda::find($id);
        if (!$denda) {
            return response()->json(['success' => false, 'message' => 'Denda tidak ditemukan', 'data' => null, 'errors' => null], 404);
        }

        if ($denda->pembayaranDendas()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Denda tidak bisa dihapus karena sudah memiliki data pembayaran',
                'data' => null,
                'errors' => null
            ], 409); // conflict
        }

        try {
            DB::beginTransaction();
            $denda->riwayatStatusDendas()->delete();
            $denda->delete();
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Denda berhasil dihapus',
                'data' => null,
                'errors' => null
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Gagal menghapus denda', 'data' => null, 'errors' => $e->getMessage()], 500);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $denda = Denda::find($id);
        if (!$denda) {
            return response()->json(['success' => false, 'message' => 'Denda tidak ditemukan', 'data' => null, 'errors' => null], 404);
        }

        $validated = $request->validate([
            'status_denda' => 'required|string|max:20',
            'alasan' => 'required|string|max:255'
        ]);

        if ($denda->status_denda === $validated['status_denda']) {
            return response()->json([
                'success' => false,
                'message' => 'Status denda sama dengan sebelumnya',
                'data' => null,
                'errors' => null
            ], 422);
        }

        try {
            DB::beginTransaction();
            $statusLama = $denda->status_denda;
            $denda->update(['status_denda' => $validated['status_denda']]);

            RiwayatStatusDenda::create([
                'id_denda' => $denda->id,
                'status_sebelum' => $statusLama,
                'status_sesudah' => $validated['status_denda'],
                'diubah_oleh' => auth('sanctum')->id() ?? null,
                'alasan' => $validated['alasan']
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Status denda berhasil diupdate',
                'data' => $denda,
                'errors' => null
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Gagal update status denda', 'data' => null, 'errors' => $e->getMessage()], 500);
        }
    }
}
