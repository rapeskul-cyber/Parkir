<?php

namespace App\Http\Controllers;

use App\Models\TiketParkir;
use App\Models\Member;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Carbon\Carbon;

class TiketController extends Controller
{
    public function qrcode($kode)
    {
        if (ob_get_length()) {
            ob_clean();
        }

        $qrSvg = trim(QrCode::format('svg')->size(150)->generate($kode));

        return response($qrSvg, 200)
            ->header('Content-Type', 'image/svg+xml; charset=utf-8');
    }

    public function create(Request $request)
    {
        try {
            // Ambil kategori dari request (default: motor jika kosong)
            $kategori = strtolower($request->kategori ?? 'motor');

            $randomNum = mt_rand(100, 999);
            $kode = "A" . $randomNum;

            while (TiketParkir::where('kode_tiket', $kode)->exists()) {
                $randomNum = mt_rand(100, 999);
                $kode = "A" . $randomNum;
            }

            $qrSvg = QrCode::format('svg')->size(200)->generate($kode);
            $qrCodeBase64 = 'data:image/svg+xml;base64,' . base64_encode($qrSvg);

            $tiket = TiketParkir::create([
                'kode_tiket'   => $kode,
                'qr_code'      => $qrCodeBase64,
                'kategori'     => $kategori, // <-- SIMPAN KATEGORI KENDARAAN (motor / mobil)
                'status'       => 'masuk',
                'waktu_masuk'  => now(),
                'waktu_keluar' => null,
            ]);
            
            return response()->json([
                'status'  => true,
                'success' => true,
                'message' => 'Tiket berhasil dibuat',
                'data'    => $tiket
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'success' => false,
                'message' => 'Gagal membuat tiket: ' . $e->getMessage()
            ], 500);
        }
    }

    public function showByKode($kode)
    {
        $tiket = TiketParkir::where('kode_tiket', $kode)->first();

        if (!$tiket) {
            return response()->json([
                'status'  => false,
                'message' => 'Kode tiket tidak ditemukan!'
            ], 404);
        }

        $waktuMasuk = Carbon::parse($tiket->waktu_masuk ?? $tiket->created_at);
        $waktuSekarang = Carbon::now();
        $durasiJam = ceil($waktuMasuk->diffInMinutes($waktuSekarang) / 60);
        if ($durasiJam < 1) $durasiJam = 1;

        return response()->json([
            'status' => true,
            'data'   => [
                'id'          => $tiket->id,
                'kode_tiket'  => $tiket->kode_tiket,
                'waktu_masuk' => $waktuMasuk->format('H:i:s d-m-Y'),
                'durasi_jam'  => $durasiJam,
                'status'      => $tiket->status
            ]
        ]);
    }

    public function keluar($id)
    {
        $tiket = TiketParkir::findOrFail($id);

        $tiket->update([
            'status' => 'keluar',
            'waktu_keluar' => now(),
        ]);

        return response()->json([
            'status'  => true,
            'success' => true,
            'data'    => $tiket
        ]);
    }

    public function index()
    {
        return response()->json([
            'status' => true,
            'data'   => TiketParkir::latest()->get()
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'status' => true,
            'data'   => TiketParkir::findOrFail($id)
        ]);
    }

    public function kendaraanAktif()
    {
        try {
            // HANYA ambil tiket yang berstatus 'masuk' (belum checkout)
            $kendaraanParkir = TiketParkir::where('status', 'masuk')
                ->latest('waktu_masuk')
                ->get()
                ->map(function ($item) {
                    $isMember = str_starts_with($item->kode_tiket, 'MBR');
                    return [
                        'id'         => $item->id,
                        'kode_tiket' => $item->kode_tiket,
                        'kategori'   => $item->kategori ?? ($isMember ? 'Mobil / Motor' : 'Motor'),
                        'no_plat'    => $item->plat_nomor ?? $item->no_plat ?? '-',
                        'created_at' => $item->waktu_masuk ?? $item->created_at,
                        'tipe'       => $isMember ? 'Member' : 'Non-Member'
                    ];
                });

            return response()->json([
                'status'  => true,
                'message' => 'Daftar gabungan kendaraan aktif',
                'data'    => $kendaraanParkir
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Gagal mengambil kendaraan aktif: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $tiket = TiketParkir::findOrFail($id);
        $tiket->delete();

        return response()->json([
            'status'  => true,
            'success' => true
        ]);
    }
}