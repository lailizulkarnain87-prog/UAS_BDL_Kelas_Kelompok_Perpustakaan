<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $query = Buku::with(['kategori', 'penerbit', 'rak']);
        if ($request->has('kategori')) {
            $query->where('id_kategori', $request->kategori);
        }
        if ($request->has('judul')) {
            $query->where('judul', 'LIKE', '%' . $request->judul . '%');
        }

        return response()->json(['success' => true, 'message' => 'Data Buku', 'data' => $query->paginate(10), 'errors' => null], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'isbn' => 'nullable|string|max:20|unique:bukus,isbn',
            'judul' => 'required|string|max:255',
            'pengarang' => 'required|string|max:150',
            'id_kategori' => 'nullable|integer|exists:kategoris,id_kategori',
            'id_penerbit' => 'nullable|integer|exists:penerbits,id_penerbit',
            'id_rak' => 'nullable|integer|exists:raks,id_rak',
            'tahun_terbit' => 'nullable|integer',
            'edisi' => 'nullable|string|max:50',
            'jumlah_halaman' => 'nullable|integer',
            'stok_total' => 'required|integer|min:0',
            'stok_tersedia' => 'required|integer|min:0',
            'bahasa' => 'nullable|string|max:50',
            'sinopsis' => 'nullable|string'
        ]);

        $buku = Buku::create($validated);
        return response()->json(['success' => true, 'message' => 'Buku dibuat', 'data' => $buku, 'errors' => null], 201);
    }

    public function show($id)
    {
        $buku = Buku::with(['kategori', 'penerbit', 'rak'])->find($id);
        if (!$buku) return response()->json(['success' => false, 'message' => 'Not found', 'data' => null, 'errors' => null], 404);
        return response()->json(['success' => true, 'message' => 'Detail Buku', 'data' => $buku, 'errors' => null], 200);
    }

    public function update(Request $request, $id)
    {
        $buku = Buku::find($id);
        if (!$buku) return response()->json(['success' => false, 'message' => 'Not found', 'data' => null, 'errors' => null], 404);

        $validated = $request->validate([
            'judul' => 'sometimes|string|max:255',
            'pengarang' => 'sometimes|string|max:150',
            'tahun_terbit' => 'nullable|integer',
            'sinopsis' => 'nullable|string'
        ]);

        $buku->update($validated);
        return response()->json(['success' => true, 'message' => 'Buku diupdate', 'data' => $buku, 'errors' => null], 200);
    }

    public function destroy($id)
    {
        $buku = Buku::find($id);
        if (!$buku) return response()->json(['success' => false, 'message' => 'Not found', 'data' => null, 'errors' => null], 404);
        
        $buku->delete();
        return response()->json(['success' => true, 'message' => 'Buku dihapus', 'data' => null, 'errors' => null], 200);
    }

    public function updateStok(Request $request, $id)
    {
        $buku = Buku::find($id);
        if (!$buku) return response()->json(['success' => false, 'message' => 'Not found', 'data' => null, 'errors' => null], 404);

        $request->validate([
            'stok_total' => 'required|integer|min:0',
            'stok_tersedia' => 'required|integer|min:0'
        ]);

        $buku->update($request->only('stok_total', 'stok_tersedia'));
        return response()->json(['success' => true, 'message' => 'Stok buku diupdate', 'data' => $buku, 'errors' => null], 200);
    }
}
