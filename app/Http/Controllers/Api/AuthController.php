<?php
// ================================================================
// Nama Sistem  : Aqualyze - Smart Water Monitoring System
// Author       : Refan Rustoni Putra(10824005), Andini Putri Yani(10824011)
// Versi        : 1.3.0
// Tahun        : 2026
// Ownership    : Capstone Project - Universitas
// Deskripsi    : Sistem monitoring kualitas air berbasis IoT
//                dengan API Laravel sebagai backend.
// ================================================================

// ======================= Library ================================
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Email atau password salah.'
            ], 401);
        }

        $user = Auth::user();

        $token = $user->createToken('flutter-token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil',
            'token' => $token,
            'user' => $user
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout berhasil'
        ]);
    }
}