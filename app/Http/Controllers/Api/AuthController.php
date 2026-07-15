<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Kredensial salah',
                'data' => null,
                'errors' => null
            ], 401);
        }

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'data' => [
                'token' => $user->createToken('auth')->plainTextToken,
                'user' => $user
            ],
            'errors' => null
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil',
            'data' => null,
            'errors' => null
        ], 200);
    }

    public function me(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Data user aktif',
            'data' => $request->user(),
            'errors' => null
        ], 200);
    }
}
