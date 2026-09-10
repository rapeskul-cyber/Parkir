<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\TiketParkir;
use Carbon\Carbon;

class MemberGateController extends Controller
{
    /**
     * 1. GATE MASUK KHUSUS MEMBER
     * Endpoint: POST /api/gate/masuk-member
     */
    public function masukMember(Request $request)
    {
        $request->validate(['kode' => 'required']);
        $kode = trim($request->kode);

        // Ambil member
        $member = Member::where('kode_member', $kode)->first();
        if (!$member) {
            return response()->json([
                'status'  => false,
                'message' => 'Member tidak terdaftar!'
            ], 404);
        }

        // Cek status lunas & expired
        $isExpired = $member->tanggal_expired && Carbon::parse($member->tanggal_expired)->isPast();
        if ($member->status !== 'lunas' || $isExpired) {
            return response()->json([
                'status'  => false,
                'message' => 'Akses ditolak: Status member belum lunas atau masa aktif expired!'
            ], 400);
        }

        // CEK APAKAH MEMBER MASIH DI DALAM (Belum Checkout/Keluar)
        $sedangDiDalam = TiketParkir::where('kode_tiket', 'LIKE', $member->kode_member . '%')
            ->where('status', 'masuk')
            ->first();

        if ($sedangDiDalam) {
            return response()->json([
                'status'  => false,
                'message' => 'Kendaraan member sudah tercatat berada di dalam area parkir!'
            ], 422);
        }

        // Buat sesi parkir baru di tiket_parkir
        $kodeSesi = $member->kode_member . '-' . date('ymdHis');
        $tiket = TiketParkir::create([
            'kode_tiket'   => $kodeSesi,
            'kategori'     => $member->kategori ?? 'Mobil',
            'plat_nomor'   => $member->plat_nomor ?? $member->nama_member,
            'status'       => 'masuk',
            'waktu_masuk'  => Carbon::now(),
            'waktu_keluar' => null,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Gate Masuk Terbuka. Selamat Datang, ' . $member->nama_member . '!',
            'data'    => $tiket
        ], 200);
    }

    /**
     * 2. GATE KELUAR (SCAN KARTU MEMBER / TIKET UMUM)
     * Endpoint: POST /api/gate/scan
     */
    public function scanGate(Request $request)
    {
        $request->validate(['kode' => 'required']);
        $kode = trim($request->kode);

        // ============================================================
        // A. CEK JIKA KODE ADALAH MEMBER
        // ============================================================
        $member = Member::where('kode_member', $kode)->first();

        // Jika discan menggunakan kode tiket sesi (misal: MBR-XXXXX-timestamp)
        if (!$member && str_starts_with($kode, 'MBR-')) {
            $parts = explode('-', $kode);
            if (count($parts) >= 2) {
                $member = Member::where('kode_member', $parts[0] . '-' . $parts[1])->first();
            }
        }

        if ($member) {
            // Cek masa aktif member
            $isExpired = $member->tanggal_expired && Carbon::parse($member->tanggal_expired)->isPast();
            if ($member->status !== 'lunas' || $isExpired) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Akses ditolak: Status member tidak aktif atau expired!'
                ], 400);
            }

            // CARI SESI MASUK AKTIF DARI MEMBER INI
            $tiketAktif = TiketParkir::where('kode_tiket', 'LIKE', $member->kode_member . '%')
                ->where('status', 'masuk')
                ->latest('id')
                ->first();

            // VALIDASI UTAMA: Kalau tidak ada data MASUK, TOLAK! TIDAK BOLEH KELUAR!
            if (!$tiketAktif) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Kendaraan member belum tercatat masuk! Tidak dapat memproses gate keluar.'
                ], 422);
            }

            // Jika benar ada sesi 'masuk', ubah jadi 'keluar'
            $tiketAktif->update([
                'status'       => 'keluar',
                'waktu_keluar' => Carbon::now(),
            ]);

            return response()->json([
                'status'  => true,
                'type'    => 'member',
                'action'  => 'keluar',
                'message' => 'Akses Member Valid. Pintu gerbang keluar terbuka otomatis.',
                'data'    => [
                    'kode_member'  => $member->kode_member,
                    'nama_member'  => $member->nama_member,
                    'waktu_masuk'  => $tiketAktif->waktu_masuk,
                    'waktu_keluar' => $tiketAktif->waktu_keluar,
                ]
            ], 200);
        }

       // ============================================================
        // B. CEK JIKA KODE ADALAH TIKET NON-MEMBER
        // ============================================================
        $tiket = TiketParkir::where('kode_tiket', $kode)->first();
        if ($tiket) {
            if ($tiket->status === 'keluar') {
                return response()->json([
                    'status'  => false,
                    'message' => 'Tiket ini sudah pernah keluar sebelumnya!'
                ], 400);
            }

            if ($tiket->status !== 'masuk') {
                return response()->json([
                    'status'  => false,
                    'message' => 'Tiket belum tercatat masuk ke area parkir!'
                ], 422);
            }

            $waktuMasuk = Carbon::parse($tiket->waktu_masuk ?? $tiket->created_at);
            $waktuKeluar = Carbon::now();
            $selisihMenit = $waktuMasuk->diffInMinutes($waktuKeluar);
            $durasiJam = max(1, (int) ceil($selisihMenit / 60));

            // TENTUKAN TARIF PER JAM BERDASARKAN KATEGORI DARI GATE MASUK
            $kategori = strtolower($tiket->kategori ?? 'motor');
            $tarifPerJam = ($kategori === 'mobil') ? 5000 : 2000;
            $totalTarif = $durasiJam * $tarifPerJam;

            return response()->json([
                'status'  => true,
                'type'    => 'tiket',
                'message' => 'Tiket valid. Silakan proses pembayaran.',
                'data'    => [
                    'id'            => $tiket->id,
                    'kode_tiket'    => $tiket->kode_tiket,
                    'kategori'      => $kategori,
                    'tarif_per_jam' => $tarifPerJam,
                    'total_tarif'   => $totalTarif,
                    'waktu_masuk'   => $waktuMasuk->toDateTimeString(),
                    'durasi_jam'    => $durasiJam
                ]
            ], 200);
        }

        return response()->json([
            'status'  => false,
            'message' => 'Kode tiket atau member tidak ditemukan di sistem!'
        ], 404);
    }
}