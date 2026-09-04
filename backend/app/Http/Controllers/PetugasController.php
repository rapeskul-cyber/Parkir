<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TiketParkir;
use App\Models\Transaksi;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Support\Str;

class PetugasController extends Controller
{
    public function scanTiketMasuk(Request $request)
    {
        $request->validate([
            'plat_nomor' => 'required|string',
            'kategori' => 'required|in:motor,mobil',
        ]);

        $kodeTiket = 'TK-' . strtoupper(Str::random(8));

        $tiket = TiketParkir::create([
            'kode_tiket' => $kodeTiket,
            'plat_nomor' => strtoupper($request->plat_nomor),
            'kategori' => $request->kategori,
            'waktu_masuk' => now(),
            'status' => 'masuk'
        ]);

        return response()->json(['message' => 'Tiket berhasil dibuat', 'tiket' => $tiket], 201);
    }

    public function scanTiketKeluar(Request $request)
    {
        $request->validate([
            'kode_tiket' => 'required|string',
        ]);

        $tiket = TiketParkir::where('kode_tiket', $request->kode_tiket)
            ->where('status', 'masuk')
            ->first();

        if (!$tiket) {
            return response()->json(['message' => 'Tiket tidak ditemukan atau sudah keluar'], 404);
        }

        $waktuMasuk = Carbon::parse($tiket->waktu_masuk);
        $waktuKeluar = now();
        $durasiMenit = $waktuMasuk->diffInMinutes($waktuKeluar);
        
        $durasiJam = ceil($durasiMenit / 60);
        if ($durasiJam == 0) $durasiJam = 1; // Minimal 1 jam

        // Cek member
        $member = Member::where('plat_nomor', $tiket->plat_nomor)
            ->where('status', 'lunas/aktif')
            ->whereDate('tanggal_berakhir', '>=', now())
            ->first();

        if ($member) {
            $totalBayar = 0; // Gratis untuk member
        } else {
            // Tarif dasar contoh: Mobil 5000/jam, Motor 3000/jam
            $tarifPerJam = $tiket->kategori === 'mobil' ? 5000 : 3000;
            $totalBayar = $durasiJam * $tarifPerJam;
        }

        return response()->json([
            'tiket' => $tiket,
            'durasi_jam' => $durasiJam,
            'is_member' => $member ? true : false,
            'total_bayar' => $totalBayar
        ]);
    }

    public function processPayment(Request $request)
    {
        $request->validate([
            'kode_tiket' => 'required|string',
            'uang_diterima' => 'required|numeric'
        ]);

        $tiket = TiketParkir::where('kode_tiket', $request->kode_tiket)
            ->where('status', 'masuk')
            ->firstOrFail();

        $waktuMasuk = Carbon::parse($tiket->waktu_masuk);
        $waktuKeluar = now();
        $durasiJam = ceil($waktuMasuk->diffInMinutes($waktuKeluar) / 60);
        if ($durasiJam == 0) $durasiJam = 1;

        $member = Member::where('plat_nomor', $tiket->plat_nomor)
            ->where('status', 'lunas/aktif')
            ->whereDate('tanggal_berakhir', '>=', now())
            ->first();

        if ($member) {
            $totalBayar = 0;
        } else {
            $tarifPerJam = $tiket->kategori === 'mobil' ? 5000 : 3000;
            $totalBayar = $durasiJam * $tarifPerJam;
        }

        if ($request->uang_diterima < $totalBayar) {
            return response()->json(['message' => 'Uang tidak cukup'], 400);
        }

        $kembalian = $request->uang_diterima - $totalBayar;

        $transaksi = Transaksi::create([
            'kode_tiket' => $tiket->kode_tiket,
            'plat_nomor' => $tiket->plat_nomor,
            'durasi_jam' => $durasiJam,
            'total_bayar' => $totalBayar,
            'kasir_id' => $request->user()->id
        ]);

        $tiket->update(['status' => 'keluar']);

        return response()->json([
            'message' => 'Pembayaran berhasil',
            'transaksi' => $transaksi,
            'kembalian' => $kembalian
        ]);
    }

    public function registerMember(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'plat_nomor' => 'required|string|unique:members',
            'no_telp' => 'required|string',
            'durasi_bulan' => 'required|integer|min:1',
            'nominal' => 'required|numeric'
        ]);

        $member = Member::create([
            'nama' => $request->nama,
            'plat_nomor' => strtoupper($request->plat_nomor),
            'no_telp' => $request->no_telp,
            'status' => 'lunas/aktif',
            'tanggal_mulai' => now()->toDateString(),
            'tanggal_berakhir' => now()->addMonths($request->durasi_bulan)->toDateString(),
            'nominal' => $request->nominal
        ]);

        // Catat transaksi pendapatan member
        Transaksi::create([
            'kode_tiket' => null,
            'plat_nomor' => $member->plat_nomor,
            'durasi_jam' => 0, // 0 untuk member bulanan
            'total_bayar' => $request->nominal,
            'kasir_id' => $request->user()->id
        ]);

        return response()->json(['message' => 'Member berhasil didaftarkan', 'member' => $member], 201);
    }

    public function checkMemberStatus(Request $request)
    {
        $request->validate([
            'plat_nomor' => 'required|string'
        ]);

        $member = Member::where('plat_nomor', strtoupper($request->plat_nomor))->first();

        if (!$member) {
            return response()->json(['message' => 'Member tidak ditemukan'], 404);
        }

        return response()->json($member);
    }

    public function extendMembership(Request $request, $id)
    {
        $request->validate([
            'durasi_bulan' => 'required|integer|min:1',
            'nominal' => 'required|numeric'
        ]);

        $member = Member::findOrFail($id);
        
        $tanggalBerakhirBaru = Carbon::parse($member->tanggal_berakhir)->isFuture() 
            ? Carbon::parse($member->tanggal_berakhir)->addMonths($request->durasi_bulan)
            : now()->addMonths($request->durasi_bulan);

        $member->update([
            'status' => 'lunas/aktif',
            'tanggal_berakhir' => $tanggalBerakhirBaru->toDateString(),
            'nominal' => $request->nominal
        ]);

        Transaksi::create([
            'kode_tiket' => null,
            'plat_nomor' => $member->plat_nomor,
            'durasi_jam' => 0,
            'total_bayar' => $request->nominal,
            'kasir_id' => $request->user()->id
        ]);

        return response()->json(['message' => 'Membership diperpanjang', 'member' => $member]);
    }
}
