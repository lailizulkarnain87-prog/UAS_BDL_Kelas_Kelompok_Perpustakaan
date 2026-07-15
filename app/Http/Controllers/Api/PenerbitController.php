<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Penerbit;
use Illuminate\Http\Request;

class PenerbitController extends Controller
{
    public function index()
    {
        return response()->json(['success' => true, 'message' => 'Data Penerbit', 'data' => Penerbit::paginate(10), 'errors' => null], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_penerbit' => 'required|string|max:100',
            'kota' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:100',
            'no_telepon' => 'nullable|string|max:15'
        ]);

        $penerbit = Penerbit::create($validated);
        return response()->json(['success' => true, 'message' => 'Penerbit dibuat', 'data' => $penerbit, 'errors' => null], 201);
    }

    public function show($id)
    {
        $penerbit = Penerbit::find($id);
        if (!$penerbit) return response()->json(['success' => false, 'message' => 'Not found', 'data' => null, 'errors' => null], 404);
        return response()->json(['success' => true, 'message' => 'Detail Penerbit', 'data' => $penerbit, 'errors' => null], 200);
    }

    public function update(Request $request, $id)
    {
        $penerbit = Penerbit::find($id);
        if (!$penerbit) return response()->json(['success' => false, 'message' => 'Not found', 'data' => null, 'errors' => null], 404);

        $validated = $request->validate([
            'nama_penerbit' => 'sometimes|string|max:100',
            'kota' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:100',
            'no_telepon' => 'nullable|string|max:15'
        ]);

        $penerbit->update($validated);
        return response()->json(['success' => true, 'message' => 'Penerbit diupdate', 'data' => $penerbit, 'errors' => null], 200);
    }

    public function destroy($id)
    {
        $penerbit = Penerbit::find($id);
        if (!$penerbit) return response()->json(['success' => false, 'message' => 'Not found', 'data' => null, 'errors' => null], 404);
        
        $penerbit->delete();
        return response()->json(['success' => true, 'message' => 'Penerbit dihapus', 'data' => null, 'errors' => null], 200);
    }
}
