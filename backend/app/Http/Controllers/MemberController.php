<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\TiketParkir;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class MemberController extends Controller
{
    public function index()
    {
        try {
            $members = Member::latest()->get();

            foreach ($members as $member) {
                if (!empty($member->tanggal_expired)) {
                    $now = Carbon::now();
                    $expired = Carbon::parse($member->tanggal_expired);

                    if ($now->greaterThan($expired) && $member->status === 'lunas') {
                        $member->status = 'belum lunas';
                        $member->save();
                    }
                }
            }

            return response()->json([
                "status" => true,
                "data"   => $members
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status"  => false,
                "message" => "Gagal mengambil data member: " . $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama_member'     => 'required',
                'nama_perusahaan' => 'required',
            ]);

            $uang_bayar   = (float) ($request->uang_bayar ?? $request->jumlah_bayar ?? 0);
            $harga_member = 150000; 
            $kembalian    = max(0, $uang_bayar - $harga_member);
            
            $status       = $uang_bayar >= $harga_member ? "lunas" : "belum lunas";

            $tanggalMulai  = Carbon::now();
            $berlakuSampai = $tanggalMulai->copy()->addMonth();

            $member = Member::create([
                'kode_member'     => $this->generateKodeMember(),
                'token'           => (string) Str::uuid(),
                'nama_member'     => $request->nama_member,
                'nama_perusahaan' => $request->nama_perusahaan,
                'total_harga'     => $harga_member,
                'jumlah_bayar'    => $uang_bayar,
                'kembalian'       => $kembalian,
                'status'          => $status,
                'tanggal_mulai'   => $tanggalMulai,
                'tanggal_expired' => $berlakuSampai
            ]);

            // Jika pendaftaran dilakukan saat masuk di pos dan langsung parkir:
            if ($status === 'lunas') {
                TiketParkir::create([
                    'kode_tiket'   => $member->kode_member,
                    'plat_nomor'   => $request->plat_nomor ?? $member->nama_member,
                    'kategori'     => $request->kategori ?? 'Mobil / Motor',
                    'status'       => 'masuk',
                    'waktu_masuk'  => now(),
                    'waktu_keluar' => null,
                ]);
            }

            return response()->json([
                "status"  => true,
                "message" => "Member berhasil dibuat",
                "data"    => $member
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                "status"  => false,
                "message" => "Gagal menyimpan member: " . $e->getMessage()
            ], 500);
        }
    }

    private function generateKodeMember()
    {
        do {
            $kode = 'MBR-' . strtoupper(Str::random(6));
        } while (Member::where('kode_member', $kode)->exists());

        return $kode;
    }

    public function show($id)
    {
        try {
            $member = Member::find($id);

            if (!$member) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Member tidak ditemukan'
                ], 404);
            }

            if ($member->status === 'lunas' && !empty($member->tanggal_expired)) {
                if (Carbon::now()->greaterThan(Carbon::parse($member->tanggal_expired))) {
                    $member->status = 'belum lunas';
                    $member->save();
                }
            }

            $svg = QrCode::format('svg')->size(200)->generate($member->kode_member);
            $qr = base64_encode($svg);

            return response()->json([
                'status' => true,
                'data'   => [
                    'id'              => $member->id,
                    'kode_member'     => $member->kode_member,
                    'nama_member'     => $member->nama_member,
                    'nama_perusahaan' => $member->nama_perusahaan,
                    'total_harga'     => $member->total_harga ?? 150000,
                    'jumlah_bayar'    => $member->jumlah_bayar ?? 0,
                    'status'          => $member->status,
                    'tanggal_mulai'   => $member->tanggal_mulai,
                    'tanggal_bayar'   => $member->tanggal_bayar,
                    'tanggal_expired' => $member->tanggal_expired,
                    'qr'              => "data:image/svg+xml;base64," . $qr
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updatePembayaran(Request $request, $id)
    {
        try {
            $member = Member::find($id);

            if (!$member) {
                return response()->json([
                    "status"  => false,
                    "message" => "Member tidak ditemukan"
                ], 404);
            }

            $request->validate([
                'jumlah_bayar' => 'required|numeric|min:0'
            ]);

            $jumlah_bayar = (float) $request->jumlah_bayar;
            $harga        = (float) ($member->total_harga ?? 150000);
            
            $status       = $jumlah_bayar >= $harga ? "lunas" : "belum lunas";

            $member->update([
                'jumlah_bayar'    => $jumlah_bayar,
                'status'          => $status,
                'tanggal_bayar'   => Carbon::now(), 
                'tanggal_expired' => Carbon::now()->addMonth()
            ]);

            return response()->json([
                "status"  => true,
                "message" => "Pembayaran member berhasil diperbarui",
                "data"    => $member
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status"  => false,
                "message" => "Gagal memperbarui pembayaran: " . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $member = Member::find($id);

            if (!$member) {
                return response()->json([
                    "status"  => false,
                    "message" => "Member tidak ditemukan"
                ], 404);
            }

            $member->delete();

            return response()->json([
                "status"  => true,
                "message" => "Member berhasil dihapus"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status"  => false,
                "message" => "Gagal menghapus member: " . $e->getMessage()
            ], 500);
        }
    }

    public function check(Request $request)
    {
        try {
            $request->validate([
                'kode_member' => 'nullable|string',
                'token'       => 'nullable|string'
            ]);

            $query = Member::query();
            if ($request->filled('kode_member')) {
                $query->where('kode_member', $request->kode_member);
            } elseif ($request->filled('token')) {
                $query->where('token', $request->token);
            } else {
                return response()->json([
                    "status"  => false,
                    "message" => "Kode member atau token wajib diisi"
                ], 422);
            }

            $member = $query->first();

            if (!$member) {
                return response()->json([
                    "status"  => false,
                    "message" => "Kartu Member Tidak Terdaftar!"
                ], 404);
            }

            if (!empty($member->tanggal_expired) && Carbon::now()->greaterThan(Carbon::parse($member->tanggal_expired))) {
                return response()->json([
                    "status"  => false,
                    "message" => "Member sudah expired"
                ], 400);
            }

            if ($member->status != "lunas") {
                return response()->json([
                    "status"  => false,
                    "message" => "Member belum melakukan pembayaran"
                ], 400);
            }

            return response()->json([
                "status"  => true,
                "message" => "Member valid",
                "data"    => $member
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status"  => false,
                "message" => "Gagal cek member: " . $e->getMessage()
            ], 500);
        }
    }
}