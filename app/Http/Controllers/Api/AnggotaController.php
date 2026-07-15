<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    public function index()
    {
        return response()->json(['success' => true, 'message' => 'Data Anggota', 'data' => Anggota::paginate(10), 'errors' => null], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_anggota' => 'required|string|max:10|unique:anggotas,kode_anggota',
            'nama_lengkap' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:anggotas,email',
            'no_telepon' => 'nullable|string|max:15',
            'alamat' => 'nullable|string',
            'tanggal_daftar' => 'required|date',
            'status_anggota' => 'sometimes|string|max:20'
        ]);

        $anggota = Anggota::create($validated);
        return response()->json(['success' => true, 'message' => 'Anggota dibuat', 'data' => $anggota, 'errors' => null], 201);
    }

    public function show($id)
    {
        $anggota = Anggota::with(['peminjamans', 'reservasis'])->find($id);
        if (!$anggota) return response()->json(['success' => false, 'message' => 'Not found', 'data' => null, 'errors' => null], 404);
        return response()->json(['success' => true, 'message' => 'Detail Anggota', 'data' => $anggota, 'errors' => null], 200);
    }

    public function update(Request $request, $id)
    {
        $anggota = Anggota::find($id);
        if (!$anggota) return response()->json(['success' => false, 'message' => 'Not found', 'data' => null, 'errors' => null], 404);

        $validated = $request->validate([
            'nama_lengkap' => 'sometimes|string|max:100',
            'email' => 'sometimes|email|max:100|unique:anggotas,email,'.$id.',id_anggota',
            'no_telepon' => 'nullable|string|max:15',
            'alamat' => 'nullable|string',
        ]);

        $anggota->update($validated);
        return response()->json(['success' => true, 'message' => 'Anggota diupdate', 'data' => $anggota, 'errors' => null], 200);
    }

    public function destroy($id)
    {
        $anggota = Anggota::find($id);
        if (!$anggota) return response()->json(['success' => false, 'message' => 'Not found', 'data' => null, 'errors' => null], 404);
        
        $anggota->delete();
        return response()->json(['success' => true, 'message' => 'Anggota dihapus', 'data' => null, 'errors' => null], 200);
    }

    public function toggleStatus(Request $request, $id)
    {
        $anggota = Anggota::find($id);
        if (!$anggota) return response()->json(['success' => false, 'message' => 'Not found', 'data' => null, 'errors' => null], 404);

        $request->validate(['status_anggota' => 'required|string|max:20']);
        $anggota->update(['status_anggota' => $request->status_anggota]);
        return response()->json(['success' => true, 'message' => 'Status anggota diupdate', 'data' => $anggota, 'errors' => null], 200);
    }
}
