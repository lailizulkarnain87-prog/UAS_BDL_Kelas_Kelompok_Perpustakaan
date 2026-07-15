<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reservasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservasiController extends Controller
{
    public function index()
    {
        $reservasi = Reservasi::with(['anggota', 'buku'])->paginate(10);
        return response()->json(['success' => true, 'message' => 'Data Reservasi', 'data' => $reservasi, 'errors' => null], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_anggota' => 'required|integer|exists:anggotas,id_anggota',
            'id_buku' => 'required|integer|exists:bukus,id_buku',
            'tanggal_reservasi' => 'required|date',
            'tanggal_kedaluwarsa' => 'required|date|after:tanggal_reservasi'
        ]);

        $exists = Reservasi::where('id_anggota', $validated['id_anggota'])
            ->where('id_buku', $validated['id_buku'])
            ->where('status_reservasi', 'menunggu')
            ->exists();

        if ($exists) {
            return response()->json(['success' => false, 'message' => 'Gagal: Reservasi untuk buku ini sudah ada dan masih menunggu', 'data' => null, 'errors' => null], 409);
        }

        $validated['status_reservasi'] = 'menunggu';
        $reservasi = Reservasi::create($validated);
        
        return response()->json(['success' => true, 'message' => 'Reservasi dibuat', 'data' => $reservasi, 'errors' => null], 201);
    }

    public function show($id)
    {
        $reservasi = Reservasi::with(['anggota', 'buku'])->find($id);
        if (!$reservasi) return response()->json(['success' => false, 'message' => 'Not found', 'data' => null, 'errors' => null], 404);
        return response()->json(['success' => true, 'message' => 'Detail Reservasi', 'data' => $reservasi, 'errors' => null], 200);
    }

    public function destroy($id)
    {
        $reservasi = Reservasi::find($id);
        if (!$reservasi) return response()->json(['success' => false, 'message' => 'Not found', 'data' => null, 'errors' => null], 404);
        
        $reservasi->delete();
        return response()->json(['success' => true, 'message' => 'Reservasi dihapus', 'data' => null, 'errors' => null], 200);
    }

    public function klaim($id)
    {
        $reservasi = Reservasi::find($id);
        if (!$reservasi) return response()->json(['success' => false, 'message' => 'Not found', 'data' => null, 'errors' => null], 404);
        
        $reservasi->update(['status_reservasi' => 'diklaim']);
        return response()->json(['success' => true, 'message' => 'Reservasi diklaim', 'data' => $reservasi, 'errors' => null], 200);
    }

    public function batal($id)
    {
        $reservasi = Reservasi::find($id);
        if (!$reservasi) return response()->json(['success' => false, 'message' => 'Not found', 'data' => null, 'errors' => null], 404);
        
        $reservasi->update(['status_reservasi' => 'batal']);
        return response()->json(['success' => true, 'message' => 'Reservasi dibatalkan', 'data' => $reservasi, 'errors' => null], 200);
    }
}
