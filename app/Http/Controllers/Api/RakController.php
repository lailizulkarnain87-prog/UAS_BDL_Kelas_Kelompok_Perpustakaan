<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rak;
use Illuminate\Http\Request;

class RakController extends Controller
{
    public function index(Request $request)
    {
        $query = Rak::query();
        if ($request->has('lantai')) {
            $query->lantai($request->lantai);
        }
        return response()->json(['success' => true, 'message' => 'Data Rak', 'data' => $query->paginate(10), 'errors' => null], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_rak' => 'required|string|max:10|unique:raks,kode_rak',
            'nama_rak' => 'required|string|max:50',
            'lantai' => 'required|integer',
            'kapasitas' => 'required|integer|min:1'
        ]);

        $rak = Rak::create($validated);
        return response()->json(['success' => true, 'message' => 'Rak dibuat', 'data' => $rak, 'errors' => null], 201);
    }

    public function show($id)
    {
        $rak = Rak::find($id);
        if (!$rak) return response()->json(['success' => false, 'message' => 'Not found', 'data' => null, 'errors' => null], 404);
        return response()->json(['success' => true, 'message' => 'Detail Rak', 'data' => $rak, 'errors' => null], 200);
    }

    public function update(Request $request, $id)
    {
        $rak = Rak::find($id);
        if (!$rak) return response()->json(['success' => false, 'message' => 'Not found', 'data' => null, 'errors' => null], 404);

        $validated = $request->validate([
            'nama_rak' => 'sometimes|string|max:50',
            'lantai' => 'sometimes|integer',
            'kapasitas' => 'sometimes|integer|min:1'
        ]);

        $rak->update($validated);
        return response()->json(['success' => true, 'message' => 'Rak diupdate', 'data' => $rak, 'errors' => null], 200);
    }

    public function destroy($id)
    {
        $rak = Rak::find($id);
        if (!$rak) return response()->json(['success' => false, 'message' => 'Not found', 'data' => null, 'errors' => null], 404);
        
        $rak->delete();
        return response()->json(['success' => true, 'message' => 'Rak dihapus', 'data' => null, 'errors' => null], 200);
    }
}
