<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Transaksi;

class LaporanController extends Controller
{
    /**
     * LAPORAN REKAP
     */
    public function rekapGlobal(Request $request)
    {
        try {
            $queryTransaksi = Transaksi::query();
            $queryMember = Member::query();

            if ($request->has('tanggal_awal') && $request->has('tanggal_akhir') && $request->tanggal_awal != '') {
                $queryTransaksi->whereBetween('created_at', [
                    $request->tanggal_awal . ' 00:00:00',
                    $request->tanggal_akhir . ' 23:59:59'
                ]);
                $queryMember->whereBetween('created_at', [
                    $request->tanggal_awal . ' 00:00:00',
                    $request->tanggal_akhir . ' 23:59:59'
                ]);
            }

            $pendapatanParkir = (clone $queryTransaksi)->sum('total_bayar');
            
            // Mencari kolom pendapatan member
            $pendapatanMember = 0;
            try {
                $pendapatanMember = (clone $queryMember)->sum('tarif') 
                                 ?? (clone $queryMember)->sum('biaya') 
                                 ?? (clone $queryMember)->sum('harga') 
                                 ?? 0;
            } catch (\Exception $ex) {
                $pendapatanMember = 0;
            }

            // Total Pendapatan Gabungan
            $totalPendapatan = $pendapatanParkir + $pendapatanMember;

            $totalTransaksi = (clone $queryTransaksi)->count();
            
            $totalMotor = 0;
            $totalMobil = 0;
            
            try {
                $totalMotor = (clone $queryTransaksi)->where('kategori', 'motor')->count();
                $totalMobil = (clone $queryTransaksi)->where('kategori', 'mobil')->count();
            } catch (\Exception $ex) {
            }

            $riwayat = $queryTransaksi->latest()->take(50)->get();

            return response()->json([
                'status' => true,
                'data' => [
                    'total_pendapatan' => $totalPendapatan,
                    'total_transaksi' => $totalTransaksi,
                    'total_motor' => $totalMotor,
                    'total_mobil' => $totalMobil,
                    'riwayat_laporan' => $riwayat
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengambil rekap global: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * LAPORAN MEMBER
     */
    public function member(Request $request)
    {
        try {
            $query = Member::query();

            if ($request->has('tanggal_awal') && $request->has('tanggal_akhir') && $request->tanggal_awal != '') {
                $query->whereBetween('created_at', [
                    $request->tanggal_awal . ' 00:00:00',
                    $request->tanggal_akhir . ' 23:59:59'
                ]);
            }

            $data = $query->latest()->get();

            return response()->json([
                'status' => true,
                'data'   => $data
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Gagal mengambil laporan member: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * LAPORAN NON-MEMBER
     */
    public function nonMember(Request $request)
    {
        try {
            $query = Transaksi::query();

            if ($request->has('tanggal_awal') && $request->has('tanggal_akhir') && $request->tanggal_awal != '') {
                $query->whereBetween('created_at', [
                    $request->tanggal_awal . ' 00:00:00',
                    $request->tanggal_akhir . ' 23:59:59'
                ]);
            }

            $data = $query->latest()->get();

            return response()->json([
                'status' => true,
                'data'   => $data
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Gagal mengambil laporan non-member: ' . $e->getMessage()
            ], 500);
        }
    }
}