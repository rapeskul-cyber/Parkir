<template>
  <div class="min-h-screen bg-[#F8FAFC] flex font-sans antialiased text-slate-800">
    <!-- SIDEBAR PERSIS REFERENSI -->
    <aside class="w-64 bg-[#0B0F19] text-slate-400 flex flex-col justify-between py-6 px-4 shrink-0 select-none hidden md:flex">
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
          <NuxtLink to="/petugas" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/40 font-semibold text-xs transition">
            <span class="text-sm">⊞</span>
            <span>Dashboard</span>
          </NuxtLink>
          <NuxtLink to="/petugas/user" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/40 text-xs font-semibold transition">
            <div class="flex items-center gap-3">
              <span class="text-sm">🟢</span>
              <span>Gate Masuk</span>
            </div>
            <span class="text-xs text-slate-600">›</span>
          </NuxtLink>
          <NuxtLink to="/petugas/keluar" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/40 text-xs font-semibold transition">
            <div class="flex items-center gap-3">
              <span class="text-sm">🚪</span>
              <span>Gate Keluar (Kasir)</span>
            </div>
            <span class="text-xs text-slate-600">›</span>
          </NuxtLink>
          <!-- Active Menu -->
          <NuxtLink to="/petugas/transaksi" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl bg-slate-800/90 text-white font-semibold text-xs shadow-xs">
            <div class="flex items-center gap-3">
              <span class="text-sm text-cyan-400">🚗</span>
              <span>Kelola Transaksi</span>
            </div>
            <span class="text-xs text-cyan-400 font-bold">●</span>
          </NuxtLink>
          <NuxtLink to="/petugas/member/select" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/40 text-xs font-semibold transition">
            <div class="flex items-center gap-3">
              <span class="text-sm">👥</span>
              <span>Kelola Member</span>
            </div>
            <span class="text-xs text-slate-600">›</span>
          </NuxtLink>
          <NuxtLink to="/petugas/laporan/member" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/40 text-xs font-semibold transition">
            <div class="flex items-center gap-3">
              <span class="text-sm">📊</span>
              <span>Laporan</span>
            </div>
            <span class="text-xs text-slate-600">›</span>
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
          <div class="w-8 h-8 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 flex items-center justify-center text-xs font-bold">
            P
          </div>
          <div class="min-w-0 flex-1">
            <p class="text-xs font-bold text-white truncate">Petugas Parkir</p>
            <p class="text-[10px] text-emerald-400 font-medium">Sistem Aktif</p>
          </div>
        </div>

        <button @click="logout" class="w-full flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold text-rose-400 hover:bg-rose-500/10 transition cursor-pointer">
          <span>🚪</span>
          <span>Logout</span>
        </button>
      </div>
    </aside>

    <!-- CONTENT -->
    <main class="flex-1 flex flex-col min-w-0 h-screen overflow-y-auto">
      <!-- HEADER -->
      <header class="bg-white px-8 py-5 flex items-center justify-between border-b border-slate-100 shrink-0">
        <div>
          <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">PLAZA ANDALAS SYSTEM</span>
          <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">Daftar Transaksi Parkir</h1>
        </div>

        <div class="flex items-center gap-3">
          <button
            @click="router.push('/petugas')"
            class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2 rounded-full text-xs font-bold transition flex items-center gap-1.5 cursor-pointer shadow-xs"
          >
            <span>←</span> Dashboard
          </button>
          <NuxtLink
            to="/petugas/keluar"
            class="bg-[#0284C7] hover:bg-[#0369A1] text-white px-4 py-2 rounded-xl font-bold text-xs shadow-xs transition flex items-center gap-1.5 cursor-pointer"
          >
            <span class="text-sm font-bold">+</span>
            <span>Kasir / Scan Keluar</span>
          </NuxtLink>
        </div>
      </header>

      <!-- BODY -->
      <div class="p-8 space-y-6">
        <!-- STATS CARD -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
          <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-xs flex items-center justify-between">
            <div>
              <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Total Transaksi</span>
              <h3 class="text-2xl font-black text-slate-900">{{ transaksis.length }} Record</h3>
              <span class="text-[11px] text-slate-400">Semua riwayat kasir</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-cyan-500/10 text-cyan-600 flex items-center justify-center font-bold">
              💳
            </div>
          </div>

          <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-xs flex items-center justify-between">
            <div>
              <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Total Penerimaan</span>
              <h3 class="text-2xl font-black text-emerald-600">Rp {{ formatRupiah(totalPenerimaan) }}</h3>
              <span class="text-[11px] text-slate-400">Total tarif terbayar</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-600 flex items-center justify-center font-bold">
              ✓
            </div>
          </div>

          <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-xs flex items-center justify-between">
            <div>
              <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Total Uang Cash</span>
              <h3 class="text-2xl font-black text-indigo-600">Rp {{ formatRupiah(totalCash) }}</h3>
              <span class="text-[11px] text-slate-400">Kembalian: Rp {{ formatRupiah(totalKembalian) }}</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-indigo-500/10 text-indigo-600 flex items-center justify-center font-bold">
              💵
            </div>
          </div>
        </div>

        <!-- SEARCH BAR -->
        <div class="flex items-center justify-between gap-4">
          <div class="relative w-72">
            <span class="absolute left-3.5 top-2.5 text-xs text-slate-400">🔍</span>
            <input
              v-model="searchQuery"
              type="text"
              placeholder="Cari plat nomor / kode tiket..."
              class="w-full pl-9 pr-4 py-2.5 bg-white border border-slate-200 rounded-2xl text-xs font-semibold focus:outline-none focus:border-[#0284C7] focus:ring-2 focus:ring-[#0284C7]/20 transition"
            />
          </div>
          <span class="text-xs font-bold text-slate-400">Menampilkan {{ filteredTransaksis.length }} transaksi</span>
        </div>

        <!-- TABEL DATA TRANSAKSI -->
        <div class="bg-white rounded-3xl border border-slate-100 shadow-xs overflow-hidden">
          <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
              <thead>
                <tr class="bg-slate-50/80 border-b border-slate-100 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                  <th class="py-3.5 px-5 text-center">No</th>
                  <th class="py-3.5 px-5 text-center">QR Code</th>
                  <th class="py-3.5 px-5">Kode Tiket</th>
                  <th class="py-3.5 px-5">Kategori</th>
                  <th class="py-3.5 px-5">No Plat</th>
                  <th class="py-3.5 px-5 text-right">Total Bayar</th>
                  <th class="py-3.5 px-5 text-right">Uang Bayar</th>
                  <th class="py-3.5 px-5 text-right">Kembalian</th>
                  <th class="py-3.5 px-5 text-center">Status</th>
                  <th class="py-3.5 px-5">Waktu Transaksi</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-100 text-xs font-semibold text-slate-700">
                <tr v-if="loading">
                  <td colspan="10" class="py-12 text-center text-slate-400 font-bold">
                    Memuat data transaksi...
                  </td>
                </tr>
                <tr v-else-if="filteredTransaksis.length === 0">
                  <td colspan="10" class="py-12 text-center text-slate-400 font-bold">
                    Belum ada transaksi recorded.
                  </td>
                </tr>
                <tr
                  v-else
                  v-for="(item, index) in filteredTransaksis"
                  :key="item.id"
                  class="hover:bg-slate-50/60 transition"
                >
                  <td class="py-4 px-5 text-center font-mono text-slate-400">{{ index + 1 }}</td>
                  <td class="py-4 px-5 text-center">
                    <div class="flex justify-center">
                      <img
                        v-if="item.kode_tiket"
                        :src="`http://localhost:8000/api/qrcode/${item.kode_tiket}`"
                        alt="QR Code"
                        class="w-10 h-10 object-contain p-1 bg-white border border-slate-100 rounded-xl shadow-2xs"
                      />
                      <span v-else class="text-slate-300">-</span>
                    </div>
                  </td>
                  <td class="py-4 px-5 font-mono font-bold text-indigo-600">{{ item.kode_tiket }}</td>
                  <td class="py-4 px-5 capitalize font-medium text-slate-600">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-xl bg-slate-100 text-[11px] font-bold">
                      {{ item.kategori?.toLowerCase() === 'mobil' ? '🚗 Mobil' : '🛵 Motor' }}
                    </span>
                  </td>
                  <td class="py-4 px-5 font-mono font-extrabold text-slate-900 uppercase">
                    {{ item.no_plat || '-' }}
                  </td>
                  <td class="py-4 px-5 text-right font-mono font-black text-slate-900">
                    Rp {{ formatRupiah(item.total_bayar) }}
                  </td>
                  <td class="py-4 px-5 text-right font-mono font-extrabold text-emerald-600">
                    Rp {{ formatRupiah(item.uang_bayar) }}
                  </td>
                  <td class="py-4 px-5 text-right font-mono text-slate-500">
                    Rp {{ formatRupiah(item.kembalian) }}
                  </td>
                  <td class="py-4 px-5 text-center">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-200/60 uppercase">
                      <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                      {{ item.status || 'lunas' }}
                    </span>
                  </td>
                  <td class="py-4 px-5 font-medium text-slate-500">
                    {{ formatDate(item.created_at) }}
                  </td>
                </tr>
              </tbody>

              <!-- FOOTER TOTAL -->
              <tfoot v-if="filteredTransaksis.length > 0" class="bg-slate-50 border-t-2 border-slate-200 text-xs font-black text-slate-900">
                <tr>
                  <td colspan="5" class="py-4 px-5 text-right uppercase tracking-wider text-slate-500">
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
                  <td colspan="2" class="py-4 px-5 text-center text-slate-400 font-normal">
                    {{ filteredTransaksis.length }} Transaksi
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
  middleware: 'auth'
})

const { $api } = useNuxtApp()
const router = useRouter()

const transaksis = ref<any[]>([])
const loading = ref(true)
const searchQuery = ref('')

const fetchTransaksi = async () => {
  loading.value = true
  try {
    const res = await $api.get('/transaksi')
    transaksis.value = res.data.data || res.data || []
  } catch (err) {
    console.error('Gagal mengambil data transaksi:', err)
    transaksis.value = []
  } finally {
    loading.value = false
  }
}

const filteredTransaksis = computed(() => {
  if (!searchQuery.value) return transaksis.value
  const query = searchQuery.value.toLowerCase()
  return transaksis.value.filter(item =>
    item.kode_tiket?.toLowerCase().includes(query) ||
    item.no_plat?.toLowerCase().includes(query) ||
    item.kategori?.toLowerCase().includes(query)
  )
})

const totalPenerimaan = computed(() => {
  return filteredTransaksis.value.reduce((acc, curr) => acc + Number(curr.total_bayar || 0), 0)
})

const totalCash = computed(() => {
  return filteredTransaksis.value.reduce((acc, curr) => acc + Number(curr.uang_bayar || 0), 0)
})

const totalKembalian = computed(() => {
  return filteredTransaksis.value.reduce((acc, curr) => acc + Number(curr.kembalian || 0), 0)
})

const formatRupiah = (val: any) => new Intl.NumberFormat('id-ID').format(Number(val || 0))

const formatDate = (dateString: any) => {
  if (!dateString) return '-'
  return new Date(dateString).toLocaleString('id-ID', {
    day: '2-digit',
    month: 'short',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}

const logout = async () => {
  try {
    await $api.post('/logout')
  } catch {}
  localStorage.removeItem('token')
  router.push('/')
}

onMounted(() => {
  fetchTransaksi()
})
</script>