<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PetugasController extends Controller
{
    public function index()
    {
        return response()->json(['success' => true, 'message' => 'Data Petugas', 'data' => Petugas::paginate(10), 'errors' => null], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_petugas' => 'required|string|max:10|unique:petugas,kode_petugas',
            'nama_petugas' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:petugas,username',
            'password' => 'required|string|min:6',
            'jabatan' => 'nullable|string|max:50',
            'no_telepon' => 'nullable|string|max:15'
        ]);

        $validated['password_hash'] = Hash::make($validated['password']);
        unset($validated['password']);

        $petugas = Petugas::create($validated);
        return response()->json(['success' => true, 'message' => 'Petugas dibuat', 'data' => $petugas, 'errors' => null], 201);
    }

    public function show($id)
    {
        $petugas = Petugas::find($id);
        if (!$petugas) return response()->json(['success' => false, 'message' => 'Not found', 'data' => null, 'errors' => null], 404);
        return response()->json(['success' => true, 'message' => 'Detail Petugas', 'data' => $petugas, 'errors' => null], 200);
    }

    public function update(Request $request, $id)
    {
        $petugas = Petugas::find($id);
        if (!$petugas) return response()->json(['success' => false, 'message' => 'Not found', 'data' => null, 'errors' => null], 404);

        $validated = $request->validate([
            'nama_petugas' => 'sometimes|string|max:100',
            'jabatan' => 'nullable|string|max:50',
            'no_telepon' => 'nullable|string|max:15'
        ]);

        $petugas->update($validated);
        return response()->json(['success' => true, 'message' => 'Petugas diupdate', 'data' => $petugas, 'errors' => null], 200);
    }

    public function destroy($id)
    {
        $petugas = Petugas::find($id);
        if (!$petugas) return response()->json(['success' => false, 'message' => 'Not found', 'data' => null, 'errors' => null], 404);
        
        $petugas->delete();
        return response()->json(['success' => true, 'message' => 'Petugas dihapus', 'data' => null, 'errors' => null], 200);
    }
}
