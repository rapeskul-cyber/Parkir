<template>
  <div class="min-h-screen bg-[#F8FAFC] flex font-sans antialiased text-slate-800">
    <!-- SIDEBAR PERSIS REFERENSI PETUGAS & ADMIN -->
    <aside class="w-64 bg-[#0B0F19] text-slate-400 flex flex-col justify-between py-6 px-4 shrink-0 select-none hidden md:flex">
      <div>
        <!-- Brand Header -->
        <div class="flex items-center justify-between px-2 mb-7">
          <div class="flex items-center gap-2.5">
            <div class="w-9 h-9 rounded-xl bg-cyan-400 text-[#0B0F19] flex items-center justify-center font-black text-base shadow-[0_0_15px_rgba(34,211,238,0.3)]">
              P
            </div>
            <div>
              <span class="text-base font-extrabold tracking-tight text-white block leading-none">ADMIN PARKIR</span>
              <span class="text-[9px] text-slate-500 font-bold uppercase tracking-widest mt-0.5 block">PLAZA ANDALAS</span>
            </div>
          </div>
          <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
        </div>

        <!-- Menu Navigation -->
        <nav class="space-y-1">
          <!-- Active Menu: Dashboard -->
          <NuxtLink
            to="/admin/dashboard"
            class="flex items-center justify-between px-3.5 py-2.5 rounded-xl bg-slate-800/90 text-white font-semibold text-xs shadow-xs"
          >
            <div class="flex items-center gap-3">
              <span class="text-sm text-cyan-400">⊞</span>
              <span>Dashboard</span>
            </div>
            <span class="text-xs text-cyan-400 font-bold">●</span>
          </NuxtLink>

          <NuxtLink
            to="/admin/petugas"
            class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/40 text-xs font-semibold transition"
          >
            <div class="flex items-center gap-3">
              <span class="text-sm">👥</span>
              <span>Kelola Petugas</span>
            </div>
            <span class="text-xs text-slate-600">›</span>
          </NuxtLink>

          <NuxtLink
            to="/admin/laporan/member"
            class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/40 text-xs font-semibold transition"
          >
            <div class="flex items-center gap-3">
              <span class="text-sm">📊</span>
              <span>Laporan</span>
            </div>
            <span class="text-xs text-slate-600">›</span>
          </NuxtLink>

          <NuxtLink
            to="/admin/markir"
            class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/40 text-xs font-semibold transition"
          >
            <div class="flex items-center gap-3">
              <span class="text-sm">🅿️</span>
              <span>Sedang Parkir</span>
            </div>
            <span class="text-xs text-slate-600">›</span>
          </NuxtLink>
        </nav>
      </div>

      <!-- Bottom Profile & Logout -->
      <div class="space-y-3 pt-4 border-t border-slate-800/80">
        <div class="bg-slate-900/90 border border-slate-800 px-3.5 py-2.5 rounded-2xl flex items-center gap-3">
          <div class="w-8 h-8 rounded-xl bg-cyan-500/10 border border-cyan-500/30 text-cyan-400 flex items-center justify-center text-xs font-bold">
            ADM
          </div>
          <div class="min-w-0 flex-1">
            <p class="text-xs font-bold text-white truncate">Super Administrator</p>
            <p class="text-[10px] text-cyan-400 font-medium">Control Center</p>
          </div>
        </div>

        <button
          @click="logout"
          class="w-full flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold text-rose-400 hover:bg-rose-500/10 transition cursor-pointer"
        >
          <span>🚪</span>
          <span>Logout</span>
        </button>
      </div>
    </aside>

    <!-- KONTEN UTAMA DASHBOARD -->
    <main class="flex-1 flex flex-col min-w-0 h-screen overflow-y-auto">
      <!-- TOP BAR -->
      <header class="bg-white px-8 py-5 flex items-center justify-between border-b border-slate-100 shrink-0">
        <div>
          <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">EXECUTIVE OVERVIEW</span>
          <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">Dashboard Plaza Andalas</h1>
        </div>

        <div class="flex items-center gap-3">
          <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-200/60">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            Realtime Radar Online
          </span>
          <div class="bg-slate-100 text-slate-700 px-3.5 py-1.5 rounded-xl text-xs font-bold">
            {{ tanggalHariIni }}
          </div>
        </div>
      </header>

      <!-- BODY DASHBOARD -->
      <div class="p-8 space-y-6">
        <!-- 4 KARTU STATISTIK UTAMA (REALTIME) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
          <!-- Member Aktif -->
          <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-xs flex items-center justify-between">
            <div>
              <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Total Member Aktif</span>
              <h3 class="text-2xl font-black text-slate-900">{{ stats.member_aktif || 0 }}</h3>
              <span class="text-[11px] text-slate-400 font-medium">Status lunas terdaftar</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-cyan-500/10 text-cyan-600 flex items-center justify-center font-bold text-lg">
              👥
            </div>
          </div>

          <!-- Kendaraan Hari Ini -->
          <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-xs flex items-center justify-between">
            <div>
              <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Kendaraan Masuk</span>
              <h3 class="text-2xl font-black text-indigo-600">{{ stats.kendaraan_hari_ini || 0 }} Unit</h3>
              <span class="text-[11px] text-slate-400 font-medium">Volume harian</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-indigo-500/10 text-indigo-600 flex items-center justify-center font-bold text-lg">
              🚗
            </div>
          </div>

          <!-- Pendapatan Hari Ini -->
          <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-xs flex items-center justify-between">
            <div>
              <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Pendapatan Hari Ini</span>
              <h3 class="text-2xl font-black text-emerald-600">Rp {{ formatRupiah(stats.pendapatan_hari_ini || 0) }}</h3>
              <span class="text-[11px] text-slate-400 font-medium">Akumulasi tarif parkir</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-600 flex items-center justify-center font-bold text-lg">
              💵
            </div>
          </div>

          <!-- Sedang Parkir -->
          <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-xs flex items-center justify-between">
            <div>
              <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Sedang Parkir</span>
              <h3 class="text-2xl font-black text-amber-600">{{ stats.sedang_parkir || 0 }} Unit</h3>
              <span class="text-[11px] text-slate-400 font-medium">Di dalam mal sekarang</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-amber-500/10 text-amber-600 flex items-center justify-center font-bold text-lg">
              🅿️
            </div>
          </div>
        </div>

        <!-- GRAFIK STATISTIK REALTIME -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-xs space-y-4">
          <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
              <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">RADAR ACTIVITY</span>
              <h3 class="text-base font-extrabold text-slate-900">Grafik Volume Kendaraan Masuk (Realtime)</h3>
            </div>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold bg-cyan-50 text-cyan-700 border border-cyan-200">
              <span class="w-1.5 h-1.5 rounded-full bg-cyan-500 animate-pulse"></span>
              Live Database Sync
            </span>
          </div>

          <div class="h-64 relative w-full">
            <Line :data="chartData" :options="chartOptions" />
          </div>
        </div>

        <!-- SHORTCUT CEPAT & AKTIVITAS TERBARU -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
          <!-- Shortcut Akses Cepat -->
          <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-xs space-y-4">
            <div>
              <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">SHORTCUT</span>
              <h3 class="text-base font-extrabold text-slate-900">Akses Cepat Pengelolaan</h3>
            </div>

            <div class="space-y-3">
              <NuxtLink
                to="/admin/petugas"
                class="flex items-center justify-between p-4 rounded-2xl bg-slate-50 hover:bg-slate-100 transition border border-slate-100 group"
              >
                <div class="flex items-center gap-3.5">
                  <div class="w-10 h-10 rounded-xl bg-cyan-500/10 text-cyan-600 flex items-center justify-center font-bold text-lg">
                    👥
                  </div>
                  <div>
                    <h4 class="text-xs font-black text-slate-900">Manajemen Petugas</h4>
                    <p class="text-[11px] text-slate-400 font-medium">Buat akun petugas kasir baru & kelola password</p>
                  </div>
                </div>
                <span class="text-slate-400 group-hover:text-slate-800 text-sm font-bold group-hover:translate-x-1 transition">›</span>
              </NuxtLink>

              <NuxtLink
                to="/admin/laporan/member"
                class="flex items-center justify-between p-4 rounded-2xl bg-slate-50 hover:bg-slate-100 transition border border-slate-100 group"
              >
                <div class="flex items-center gap-3.5">
                  <div class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-600 flex items-center justify-center font-bold text-lg">
                    📊
                  </div>
                  <div>
                    <h4 class="text-xs font-black text-slate-900">Laporan & Audit Keuangan</h4>
                    <p class="text-[11px] text-slate-400 font-medium">Rekapitulasi pembayaran member dan tiket harian</p>
                  </div>
                </div>
                <span class="text-slate-400 group-hover:text-slate-800 text-sm font-bold group-hover:translate-x-1 transition">›</span>
              </NuxtLink>
            </div>
          </div>

          <!-- Log Aktivitas Terbaru -->
          <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-xs space-y-4">
            <div>
              <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">TRANSACTION LOG</span>
              <h3 class="text-base font-extrabold text-slate-900">Aktivitas Terakhir Kasir</h3>
            </div>

            <div class="space-y-3">
              <div v-if="aktivitasTerbaru.length === 0" class="text-xs text-slate-400 font-bold text-center py-6">
                Belum ada data transaksi kasir terbaru.
              </div>

              <div
                v-for="item in aktivitasTerbaru"
                :key="item.id"
                class="flex items-center justify-between p-3.5 rounded-2xl bg-slate-50 border border-slate-100 hover:bg-slate-100/70 transition"
              >
                <div class="flex items-center gap-3 min-w-0">
                  <div class="w-9 h-9 rounded-xl bg-emerald-500/10 text-emerald-600 flex items-center justify-center text-xs font-black">
                    ✓
                  </div>
                  <div class="min-w-0">
                    <h4 class="text-xs font-black text-slate-900 font-mono uppercase truncate">
                      {{ item.no_plat || item.plat_nomor || '-' }}
                    </h4>
                    <p class="text-[10px] text-slate-400 font-mono">
                      Tiket: {{ item.kode_tiket }} | Rp {{ formatRupiah(item.total_bayar || item.total_tarif || 0) }}
                    </p>
                  </div>
                </div>
                <span class="text-[11px] font-bold text-slate-500 font-mono shrink-0">
                  {{ formatWaktu(item.created_at) }}
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue'
import { Line } from 'vue-chartjs'
import { 
  Chart as ChartJS, 
  CategoryScale, 
  LinearScale, 
  PointElement, 
  LineElement, 
  Title, 
  Tooltip, 
  Legend,
  Filler
} from 'chart.js'

ChartJS.register(CategoryScale, LinearScale, PointElement, LineElement, Title, Tooltip, Legend, Filler)

definePageMeta({
  middleware: ['auth', 'cek-admin']
})

const { $api } = useNuxtApp()
const router = useRouter()

const stats = ref({
  member_aktif: 0,
  kendaraan_hari_ini: 0,
  pendapatan_hari_ini: 0,
  sedang_parkir: 0
})

const chartData = ref<any>({
  labels: ['06:00', '08:00', '10:00', '12:00', '14:00', '16:00', '18:00', '20:00', '22:00'],
  datasets: [
    {
      label: 'Hari Ini',
      backgroundColor: 'rgba(34, 211, 238, 0.12)',
      borderColor: '#0284C7',
      borderWidth: 2.5,
      pointBackgroundColor: '#0284C7',
      pointBorderColor: '#ffffff',
      pointHoverRadius: 6,
      fill: true,
      data: [0, 0, 0, 0, 0, 0, 0, 0, 0],
      tension: 0.35,
    },
    {
      label: 'Kemarin',
      backgroundColor: 'transparent',
      borderColor: '#94A3B8',
      borderWidth: 1.5,
      borderDash: [5, 5],
      pointRadius: 0,
      data: [0, 0, 0, 0, 0, 0, 0, 0, 0],
      tension: 0.35,
    }
  ]
})

const chartOptions = ref({
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: {
      display: true,
      position: 'top' as const,
      labels: {
        boxWidth: 12,
        font: { size: 11, weight: 'bold' }
      }
    }
  },
  scales: {
    y: {
      beginAtZero: true,
      grid: { color: 'rgba(241, 245, 249, 1)' },
      ticks: { precision: 0, font: { size: 10 } }
    },
    x: {
      grid: { display: false },
      ticks: { font: { size: 10 } }
    }
  }
})

const aktivitasTerbaru = ref<any[]>([])
const tanggalHariIni = ref(new Date().toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }))

let intervalId: any = null

const loadDashboardData = async () => {
  try {
    const res = await $api.get('/dashboard/stats')
    if (res.data && res.data.data) {
      stats.value = res.data.data

      if (res.data.data.transaksi_terbaru) {
        aktivitasTerbaru.value = res.data.data.transaksi_terbaru
      }

      // Sinkronisasi Grafik dengan data riil dari backend DashboardController
      if (res.data.data.chart && res.data.data.chart.today) {
        const chartBackend = res.data.data.chart.today
        chartData.value = {
          labels: chartBackend.labels || chartData.value.labels,
          datasets: [
            {
              ...chartData.value.datasets[0],
              data: chartBackend.current || []
            },
            {
              ...chartData.value.datasets[1],
              data: chartBackend.previous || []
            }
          ]
        }
      }
    }
  } catch (error) {
    console.error('Gagal mengambil data realtime dashboard:', error)
  }
}

const formatRupiah = (val: any) => {
  const num = Number(val)
  if (isNaN(num)) return '0'
  return new Intl.NumberFormat('id-ID').format(num)
}

const formatWaktu = (dateStr: string) => {
  if (!dateStr) return '-'
  return new Date(dateStr).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' })
}

const logout = async () => {
  try {
    await $api.post('/logout')
  } catch {}
  localStorage.removeItem('token')
  router.push('/')
}

onMounted(() => {
  loadDashboardData()
  intervalId = setInterval(loadDashboardData, 5000)
})

onUnmounted(() => {
  if (intervalId) clearInterval(intervalId)
})
</script>