<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\TiketParkir;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    public function index()
    {
        try {
            $transaksis = Transaksi::orderBy('created_at', 'desc')->get();
            return response()->json([
                'status'  => true,
                'message' => 'Berhasil mengambil data transaksi',
                'data'    => $transaksis
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Gagal mengambil data: ' . $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        // Validasi disesuaikan dengan payload dari Nuxt (tiket_id & bayar)
        $request->validate([
            'tiket_id'    => 'required',
            'bayar'       => 'required|numeric|min:0',
            'total_bayar' => 'required|numeric|min:0',
        ]);

        $uangBayar = $request->bayar;
        $tarif = $request->total_bayar;

        if ($uangBayar < $tarif) {
            return response()->json([
                'status'  => false,
                'message' => 'Uang bayar kurang!'
            ], 400);
        }

        // Ambil data tiket berdasarkan tiket_id
        $tiket = TiketParkir::find($request->tiket_id);
        $kodeTiket = $tiket ? $tiket->kode_tiket : ('TIKET-' . $request->tiket_id);

        // Update status tiket jika ada
        if ($tiket) {
            $tiket->status = 'keluar';
            $tiket->save();
        }

        $kembalian = $uangBayar - $tarif;

        //  Simpan transaksi keuangan
        $transaksi = Transaksi::create([
            'kode_tiket'    => $kodeTiket,
            'kategori'      => $request->kategori ?? 'motor',
            'no_plat'       => $request->nopol ?? '-',
            'total_bayar'   => $tarif,
            'uang_bayar'    => $uangBayar,
            'kembalian'     => $kembalian,
            'status'        => 'lunas',
            'tanggal_bayar' => Carbon::now()
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Pembayaran berhasil, gate terbuka!',
            'data'    => $transaksi
        ], 200);
    }
}