<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        return response()->json(['success' => true, 'message' => 'Data Kategori', 'data' => Kategori::paginate(10), 'errors' => null], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_kategori' => 'required|string|max:10|unique:kategoris,kode_kategori',
            'nama_kategori' => 'required|string|max:100',
            'deskripsi' => 'nullable|string'
        ]);

        $kategori = Kategori::create($validated);
        return response()->json(['success' => true, 'message' => 'Kategori dibuat', 'data' => $kategori, 'errors' => null], 201);
    }

    public function show($id)
    {
        $kategori = Kategori::find($id);
        if (!$kategori) return response()->json(['success' => false, 'message' => 'Not found', 'data' => null, 'errors' => null], 404);
        return response()->json(['success' => true, 'message' => 'Detail Kategori', 'data' => $kategori, 'errors' => null], 200);
    }

    public function update(Request $request, $id)
    {
        $kategori = Kategori::find($id);
        if (!$kategori) return response()->json(['success' => false, 'message' => 'Not found', 'data' => null, 'errors' => null], 404);

        $validated = $request->validate([
            'nama_kategori' => 'sometimes|string|max:100',
            'deskripsi' => 'nullable|string'
        ]);

        $kategori->update($validated);
        return response()->json(['success' => true, 'message' => 'Kategori diupdate', 'data' => $kategori, 'errors' => null], 200);
    }

    public function destroy($id)
    {
        $kategori = Kategori::find($id);
        if (!$kategori) return response()->json(['success' => false, 'message' => 'Not found', 'data' => null, 'errors' => null], 404);
        
        $kategori->delete();
        return response()->json(['success' => true, 'message' => 'Kategori dihapus', 'data' => null, 'errors' => null], 200);
    }
}
