<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Member;
use App\Models\TiketParkir;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function getDashboardStats()
    {
        $today = Carbon::today();
        
        $pendapatanHariIni = Transaksi::whereDate('created_at', $today)->sum('total_bayar');
        $tiketMasukHariIni = TiketParkir::whereDate('waktu_masuk', $today)->count();
        $memberAktif = Member::where('status', 'lunas/aktif')->count();
        $kendaraanParkir = TiketParkir::where('status', 'masuk')->count();

        // Chart data for the last 7 days
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartData['labels'][] = $date->format('Y-m-d');
            $chartData['pendapatan'][] = Transaksi::whereDate('created_at', $date)->sum('total_bayar');
        }

        return response()->json([
            'pendapatan_hari_ini' => $pendapatanHariIni,
            'tiket_masuk_hari_ini' => $tiketMasukHariIni,
            'member_aktif' => $memberAktif,
            'kendaraan_parkir' => $kendaraanParkir,
            'chart_data' => $chartData
        ]);
    }

    public function getPetugas()
    {
        $petugas = User::where('role', 'petugas')->get();
        return response()->json($petugas);
    }

    public function createPetugas(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'petugas',
        ]);

        return response()->json(['message' => 'Petugas created successfully', 'user' => $user], 201);
    }

    public function updatePetugas(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'string|max:255',
            'email' => 'string|email|max:255|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:8',
        ]);

        $user->name = $request->name ?? $user->name;
        $user->email = $request->email ?? $user->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return response()->json(['message' => 'Petugas updated successfully', 'user' => $user]);
    }

    public function deletePetugas($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['message' => 'Petugas deleted successfully']);
    }

    public function getLaporanMember(Request $request)
    {
        $query = Member::query();
        
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('tanggal_mulai', [$request->start_date, $request->end_date]);
        }

        return response()->json($query->get());
    }

    public function getLaporanNonMember(Request $request)
    {
        $query = Transaksi::query()->with('kasir:id,name');
        
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        }

        return response()->json($query->get());
    }
}
