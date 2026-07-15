<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Denda;
use App\Models\RiwayatStatusDenda;
use Illuminate\Http\Request;

class RiwayatStatusDendaController extends Controller
{
    public function index($dendaId)
    {
        $denda = Denda::find($dendaId);
        if (!$denda) {
            return response()->json(['success' => false, 'message' => 'Denda tidak ditemukan', 'data' => null, 'errors' => null], 404);
        }

        $riwayat = $denda->riwayatStatusDendas()->with('petugas')->latest()->get();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil riwayat status denda',
            'data' => $riwayat,
            'errors' => null
        ], 200);
    }
}
