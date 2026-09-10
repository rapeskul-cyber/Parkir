<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Menampilkan daftar semua petugas
    public function index()
    {
        try {
            $users = User::latest()->get(); 
            return response()->json([
                'status' => true,
                'data' => $users
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'ERROR DI DATABASE/KODE: ' . $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ], 500);
        }
    }

    // Menyimpan petugas baru
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6',
                'role' => 'required|in:petugas,admin',
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Akun berhasil ditambahkan!',
                'data' => $user
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menyimpan akun: ' . $e->getMessage()
            ], 500);
        }
    }

    // Untuk Admin mereset password petugas
    public function updatePassword(Request $request, $id)
    {
        try {
            $request->validate([
                'password' => 'required|min:6'
            ]);

            $user = User::find($id);
            if (!$user) {
                return response()->json([
                    'status' => false, 
                    'message' => 'Petugas tidak ditemukan'
                ], 404);
            }

            $user->password = Hash::make($request->password);
            $user->save();

            return response()->json([
                'status' => true, 
                'message' => 'Password petugas berhasil direset!'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mereset password: ' . $e->getMessage()
            ], 500);
        }
    }

    // Menghapus akun petugas
    public function destroy($id)
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Akun petugas tidak ditemukan'
                ], 404);
            }

            $user->delete();

            return response()->json([
                'status' => true,
                'message' => 'Akun petugas berhasil dihapus'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus petugas: ' . $e->getMessage()
            ], 500);
        }
    }
}