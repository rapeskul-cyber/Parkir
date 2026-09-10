<template>
  <div class="min-h-screen bg-[#F8FAFC] flex font-sans antialiased text-slate-800">
    <!-- SIDEBAR PERSIS REFERENSI (HILANG SAAT PRINT) -->
    <aside class="print:hidden w-64 bg-[#0B0F19] text-slate-400 flex flex-col justify-between py-6 px-4 shrink-0 select-none hidden md:flex">
      <div>
        <div class="flex items-center justify-between px-2 mb-7">
          <div class="flex items-center gap-2.5">
            <div class="w-9 h-9 rounded-xl bg-cyan-400 text-[#0B0F19] flex items-center justify-center font-black text-base shadow-[0_0_15px_rgba(34,211,238,0.3)]">
              P
            </div>
            <div>
              <span class="text-base font-extrabold tracking-tight text-white block leading-none">PARKIR</span>
              <span class="text-[9px] text-slate-500 font-bold uppercase tracking-widest mt-0.5 block">PLAZA ANDALAS</span>
            </div>
          </div>
          <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
        </div>

        <nav class="space-y-1">
          <NuxtLink to="/admin/dashboard" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/40 font-semibold text-xs transition">
            <span class="text-sm">⊞</span>
            <span>Dashboard</span>
          </NuxtLink>
          <NuxtLink to="/admin/petugas" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/40 text-xs font-semibold transition">
            <div class="flex items-center gap-3">
              <span class="text-sm">👥</span>
              <span>Kelola Petugas</span>
            </div>
            <span class="text-xs text-slate-600">›</span>
          </NuxtLink>
          <!-- CUKUP 1 MENU: LAPORAN (AKTIF) -->
          <NuxtLink to="/admin/laporan/member" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl bg-slate-800/90 text-white font-semibold text-xs shadow-xs">
            <div class="flex items-center gap-3">
              <span class="text-sm text-cyan-400">📊</span>
              <span>Laporan</span>
            </div>
            <span class="text-xs text-cyan-400 font-bold">●</span>
          </NuxtLink>
          <NuxtLink to="/petugas/markir" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/40 text-xs font-semibold transition">
            <div class="flex items-center gap-3">
              <span class="text-sm">🅿️</span>
              <span>Sedang Parkir</span>
            </div>
            <span class="text-xs text-slate-600">›</span>
          </NuxtLink>
        </nav>
      </div>

      <div class="space-y-3 pt-4 border-t border-slate-800/80">
        <div class="bg-slate-900/90 border border-slate-800 px-3.5 py-2.5 rounded-2xl flex items-center gap-3">
          <div class="w-8 h-8 rounded-xl bg-cyan-500/10 border border-cyan-500/30 text-cyan-400 flex items-center justify-center text-xs font-bold">
            A
          </div>
          <div class="min-w-0 flex-1">
            <p class="text-xs font-bold text-white truncate">Admin Parkir</p>
            <p class="text-[10px] text-cyan-400 font-medium">Audit Keuangan</p>
          </div>
        </div>

        <button @click="logout" class="w-full flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold text-rose-400 hover:bg-rose-500/10 transition cursor-pointer">
          <span>🚪</span>
          <span>Logout</span>
        </button>
      </div>
    </aside>

    <!-- CONTENT -->
    <main class="flex-1 flex flex-col min-w-0 h-screen overflow-y-auto print:h-auto print:overflow-visible">
      <!-- HEADER TOPBAR -->
      <header class="print:hidden bg-white px-8 py-5 flex items-center justify-between border-b border-slate-100 shrink-0">
        <div>
          <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">PLAZA ANDALAS AUDIT LOG</span>
          <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">Laporan Pembayaran Parkir</h1>
        </div>

        <div class="flex items-center gap-2.5">
          <button @click="cetak" class="bg-[#0284C7] hover:bg-[#0369A1] text-white text-xs font-black px-4 py-2 rounded-xl transition cursor-pointer shadow-xs flex items-center gap-1.5">
            <span>🖨️</span> Cetak Laporan
          </button>
          <NuxtLink to="/admin/dashboard" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow-xs">
            <span>←</span> Dashboard
          </NuxtLink>
        </div>
      </header>

      <!-- PRINT-ONLY HEADER BANNER -->
      <div class="hidden print:block p-6 text-center border-b-2 border-black mb-4">
        <h1 class="text-2xl font-black uppercase">LAPORAN PEMBAYARAN KARTU MEMBER</h1>
        <p class="text-sm font-bold">PLAZA ANDALAS MANAGEMENT SYSTEM</p>
        <p class="text-xs text-slate-600 mt-1">Dicetak pada: {{ new Date().toLocaleString('id-ID') }}</p>
      </div>

      <!-- BODY -->
      <div class="p-8 space-y-6 print:p-0">
        <!-- TOP CONTROLS: TAB PINDAH & SEARCH -->
        <div class="print:hidden flex flex-col sm:flex-row sm:items-center justify-between gap-4">
          <!-- Switcher Tab -->
          <div class="flex bg-slate-200/80 p-1 rounded-2xl w-fit">
            <button
              class="px-5 py-2 rounded-xl text-xs font-black bg-[#0B0F19] text-white shadow-xs cursor-default"
            >
              Langganan Member
            </button>
            <NuxtLink
              to="/admin/laporan/non-member"
              class="px-5 py-2 rounded-xl text-xs font-black text-slate-600 hover:text-slate-900 transition"
            >
              Tiket Non-Member →
            </NuxtLink>
          </div>

          <!-- Search Bar -->
          <div class="relative w-72">
            <span class="absolute left-3.5 top-2.5 text-xs text-slate-400">🔍</span>
            <input
              v-model="searchQuery"
              type="text"
              placeholder="Cari plat nomor / nama member..."
              class="w-full pl-9 pr-4 py-2.5 bg-white border border-slate-200 rounded-2xl text-xs font-semibold focus:outline-none focus:border-[#0284C7] focus:ring-2 focus:ring-[#0284C7]/20 transition"
            />
          </div>
        </div>

        <!-- STATS CARD RINGKASAN -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 print:hidden">
          <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-xs flex items-center justify-between">
            <div>
              <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Total Transaksi</span>
              <h3 class="text-2xl font-black text-slate-900">{{ filteredList.length }} Record</h3>
              <span class="text-[11px] text-slate-400">Perpanjangan member</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-cyan-500/10 text-cyan-600 flex items-center justify-center font-bold text-lg">
              👥
            </div>
          </div>

          <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-xs flex items-center justify-between">
            <div>
              <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Total Nominal Lunas</span>
              <h3 class="text-2xl font-black text-emerald-600">Rp {{ formatRupiah(totalPenerimaan) }}</h3>
              <span class="text-[11px] text-slate-400">Pemasukan iuran member</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-600 flex items-center justify-center font-bold text-lg">
              ✓
            </div>
          </div>

          <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-xs flex items-center justify-between">
            <div>
              <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Total Uang Cash</span>
              <h3 class="text-2xl font-black text-indigo-600">Rp {{ formatRupiah(totalCash) }}</h3>
              <span class="text-[11px] text-slate-400">Kembalian: Rp {{ formatRupiah(totalKembalian) }}</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-indigo-500/10 text-indigo-600 flex items-center justify-center font-bold text-lg">
              💵
            </div>
          </div>
        </div>

        <!-- TABEL DATA LAPORAN MEMBER -->
        <div class="bg-white rounded-3xl border border-slate-100 shadow-xs overflow-hidden print:border-black print:rounded-none">
          <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
              <thead>
                <tr class="bg-slate-50/80 border-b border-slate-100 text-[11px] font-bold text-slate-400 uppercase tracking-wider print:bg-slate-100 print:text-black">
                  <th class="py-3.5 px-5">No. Plat</th>
                  <th class="py-3.5 px-5">Nama Member</th>
                  <th class="py-3.5 px-5 text-center">Bulan / Periode</th>
                  <th class="py-3.5 px-5 text-right">Payment</th>
                  <th class="py-3.5 px-5 text-right">Cash</th>
                  <th class="py-3.5 px-5 text-right">Kembali</th>
                  <th class="py-3.5 px-5">Petugas</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-100 text-xs font-semibold text-slate-700">
                <tr v-if="filteredList.length === 0">
                  <td colspan="7" class="py-12 text-center text-slate-400 font-bold">
                    Tidak ada data pembayaran member yang ditemukan.
                  </td>
                </tr>
                <tr v-for="item in filteredList" :key="item.id" class="hover:bg-slate-50/60 transition">
                  <td class="py-4 px-5 font-mono font-black text-slate-900 uppercase">{{ item.no_plat || item.plat_nomor || '-' }}</td>
                  <td class="py-4 px-5 font-bold text-cyan-700">{{ item.nama_member }}</td>
                  <td class="py-4 px-5 text-center font-mono text-slate-600">{{ item.bulan || '-' }}</td>
                  <td class="py-4 px-5 text-right font-mono font-black text-emerald-600">Rp {{ formatRupiah(item.total_harga || 150000) }}</td>
                  <td class="py-4 px-5 text-right font-mono font-extrabold text-indigo-600">Rp {{ formatRupiah(item.jumlah_bayar || item.total_harga || 150000) }}</td>
                  <td class="py-4 px-5 text-right font-mono text-slate-500">Rp {{ formatRupiah(item.kembalian || 0) }}</td>
                  <td class="py-4 px-5 capitalize font-medium text-slate-600">{{ item.petugas?.nama || 'Admin' }}</td>
                </tr>
              </tbody>

              <!-- FOOTER TOTAL REKAP -->
              <tfoot v-if="filteredList.length > 0" class="bg-slate-50 border-t-2 border-slate-200 text-xs font-black text-slate-900">
                <tr>
                  <td colspan="3" class="py-4 px-5 text-right uppercase tracking-wider text-slate-500">
                    TOTAL
                  </td>
                  <td class="py-4 px-5 text-right font-mono text-emerald-600">
                    Rp {{ formatRupiah(totalPenerimaan) }}
                  </td>
                  <td class="py-4 px-5 text-right font-mono text-indigo-700">
                    Rp {{ formatRupiah(totalCash) }}
                  </td>
                  <td class="py-4 px-5 text-right font-mono text-slate-600">
                    Rp {{ formatRupiah(totalKembalian) }}
                  </td>
                  <td class="py-4 px-5 text-slate-400 font-normal">
                    {{ filteredList.length }} Member
                  </td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'

definePageMeta({ 
  middleware: ['auth', 'cek-admin'] 
})

const { $api } = useNuxtApp()
const router = useRouter()
const laporanList = ref<any[]>([])
const searchQuery = ref('')

const fetchLaporan = async () => {
  try {
    const res = await $api.get('/laporan/member')
    laporanList.value = res.data.data || []
  } catch (err) {
    console.error('Gagal mengambil laporan member:', err)
  }
}

const filteredList = computed(() => {
  return laporanList.value.filter(item => 
    item.nama_member?.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
    (item.no_plat || item.plat_nomor || '').toLowerCase().includes(searchQuery.value.toLowerCase())
  )
})

const totalPenerimaan = computed(() => {
  return filteredList.value.reduce((acc, curr) => acc + Number(curr.total_harga || 150000), 0)
})

const totalCash = computed(() => {
  return filteredList.value.reduce((acc, curr) => acc + Number(curr.jumlah_bayar || curr.total_harga || 150000), 0)
})

const totalKembalian = computed(() => {
  return filteredList.value.reduce((acc, curr) => acc + Number(curr.kembalian || 0), 0)
})

const cetak = () => window.print()
const formatRupiah = (val: any) => new Intl.NumberFormat('id-ID').format(Number(val || 0))

const logout = async () => {
  try { await $api.post('/logout') } catch {}
  localStorage.removeItem('token')
  router.push('/')
}

onMounted(() => fetchLaporan())
</script>