<script setup lang="ts">
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { Line, Bar } from 'vue-chartjs'
import {
  Chart as ChartJS,
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  BarElement,
  Title,
  Tooltip,
  Legend,
  Filler
} from 'chart.js'

ChartJS.register(
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  BarElement,
  Title,
  Tooltip,
  Legend,
  Filler
)

definePageMeta({
  middleware: 'auth'
})

const { $api } = useNuxtApp()
const router = useRouter()

const stats = ref({
  member_aktif: 0,
  kendaraan_hari_ini: 0,
  pendapatan_hari_ini: 0,
  sedang_parkir: 0
})

const timeFilter = ref<'today' | 'week' | 'month'>('today')
const chartMode = ref<'bar' | 'line'>('line')
const aktivitasTerbaru = ref<any[]>([])
let intervalId: any = null

// State penampung chart 100% data backend
const serverCharts = ref({
  today: {
    labels: ['06:00', '08:00', '10:00', '12:00', '14:00', '16:00', '18:00', '20:00', '22:00'],
    current: [0, 0, 0, 0, 0, 0, 0, 0, 0],
    previous: [0, 0, 0, 0, 0, 0, 0, 0, 0],
    currLabel: 'Hari Ini',
    prevLabel: 'Kemarin'
  },
  week: {
    labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
    current: [0, 0, 0, 0, 0, 0, 0],
    previous: [0, 0, 0, 0, 0, 0, 0],
    currLabel: 'Minggu Ini',
    prevLabel: 'Minggu Lalu'
  },
  month: {
    labels: ['Mgg 1', 'Mgg 2', 'Mgg 3', 'Mgg 4'],
    current: [0, 0, 0, 0],
    previous: [0, 0, 0, 0],
    currLabel: 'Bulan Ini',
    prevLabel: 'Bulan Lalu'
  }
})

const datasetsByFilter = computed(() => {
  return serverCharts.value[timeFilter.value]
})

const chartData = computed(() => ({
  labels: datasetsByFilter.value.labels,
  datasets: [
    {
      label: datasetsByFilter.value.currLabel,
      borderColor: '#4F46E5',
      backgroundColor: chartMode.value === 'bar' ? '#4F46E5' : 'rgba(79, 70, 229, 0.08)',
      fill: chartMode.value === 'line',
      borderWidth: 2.5,
      borderRadius: chartMode.value === 'bar' ? 6 : 0,
      pointRadius: chartMode.value === 'line' ? 3 : 0,
      pointHoverRadius: 6,
      pointBackgroundColor: '#4F46E5',
      tension: 0.35,
      data: datasetsByFilter.value.current
    },
    {
      label: datasetsByFilter.value.prevLabel,
      borderColor: '#F59E0B',
      backgroundColor: chartMode.value === 'bar' ? '#F59E0B' : 'rgba(245, 158, 11, 0.05)',
      fill: chartMode.value === 'line',
      borderWidth: 2,
      borderRadius: chartMode.value === 'bar' ? 6 : 0,
      pointRadius: chartMode.value === 'line' ? 3 : 0,
      pointHoverRadius: 6,
      pointBackgroundColor: '#F59E0B',
      tension: 0.35,
      data: datasetsByFilter.value.previous
    }
  ]
}))

const chartOptions = ref({
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: { display: false },
    tooltip: {
      backgroundColor: '#0B0F19',
      titleFont: { size: 11, weight: 'bold' },
      bodyFont: { size: 11 },
      padding: 10,
      cornerRadius: 8
    }
  },
  scales: {
    x: {
      grid: { display: false },
      ticks: { color: '#94A3B8', font: { size: 11, weight: 'bold' } }
    },
    y: {
      border: { dash: [4, 4] },
      grid: { color: '#F1F5F9' },
      ticks: {
        color: '#94A3B8',
        font: { size: 11 },
        precision: 0
      }
    }
  }
})

const loadDashboardData = async () => {
  try {
    const res = await $api.get('/dashboard/stats')
    if (res.data?.data) {
      stats.value = res.data.data
      if (res.data.data.transaksi_terbaru) {
        aktivitasTerbaru.value = res.data.data.transaksi_terbaru
      }
      if (res.data.data.chart) {
        serverCharts.value = res.data.data.chart
      }
    }

    const resAktif = await $api.get('/parkir/aktif')
    if (resAktif.data?.data) {
      stats.value.sedang_parkir = resAktif.data.data.length
    }
  } catch (error) {
    console.error('Failed to retrieve dashboard metrics', error)
  }
}

const formatRupiah = (val: any) => {
  const num = Number(val)
  return isNaN(num) ? '0' : new Intl.NumberFormat('id-ID').format(num)
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
  intervalId = setInterval(loadDashboardData, 3000)
})

onUnmounted(() => {
  if (intervalId) clearInterval(intervalId)
})
</script>

<template>
  <div class="min-h-screen bg-[#F8FAFC] flex font-sans antialiased text-slate-800">
    <aside class="w-64 bg-[#0B0F19] text-slate-400 flex flex-col justify-between py-6 px-4 shrink-0 select-none hidden md:flex">
      <div>
        <div class="flex items-center justify-between px-2 mb-7">
          <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-xl bg-cyan-500 text-[#0B0F19] flex items-center justify-center font-black text-sm">
              P
            </div>
            <div>
              <span class="text-base font-extrabold tracking-tight text-white block leading-none">PARKIR</span>
              <span class="text-[9px] text-slate-500 font-bold uppercase tracking-widest">PLAZA ANDALAS</span>
            </div>
          </div>
          <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
        </div>

        <nav class="space-y-1">
          <NuxtLink
            to="/petugas"
            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl bg-slate-800/90 text-white font-semibold text-xs transition shadow-xs"
          >
            <span class="text-sm">⊞</span>
            <span>Dashboard</span>
          </NuxtLink>

          <NuxtLink
            to="/petugas/user"
            class="flex items-center justify-between px-3.5 py-2.5 rounded-xl hover:bg-slate-800/40 hover:text-white text-xs font-semibold transition"
          >
            <div class="flex items-center gap-3">
              <span class="text-sm">🟢</span>
              <span>Gate Masuk</span>
            </div>
            <span class="text-xs text-slate-600">›</span>
          </NuxtLink>

          <NuxtLink
            to="/petugas/keluar"
            class="flex items-center justify-between px-3.5 py-2.5 rounded-xl hover:bg-slate-800/40 hover:text-white text-xs font-semibold transition"
          >
            <div class="flex items-center gap-3">
              <span class="text-sm">🚪</span>
              <span>Gate Keluar (Kasir)</span>
            </div>
            <span class="text-xs text-slate-600">›</span>
          </NuxtLink>

          <NuxtLink
            to="/petugas/transaksi"
            class="flex items-center justify-between px-3.5 py-2.5 rounded-xl hover:bg-slate-800/40 hover:text-white text-xs font-semibold transition"
          >
            <div class="flex items-center gap-3">
              <span class="text-sm">🚗</span>
              <span>Kelola Transaksi</span>
            </div>
            <span class="text-xs text-slate-600">›</span>
          </NuxtLink>

          <NuxtLink
            to="/petugas/member/select"
            class="flex items-center justify-between px-3.5 py-2.5 rounded-xl hover:bg-slate-800/40 hover:text-white text-xs font-semibold transition"
          >
            <div class="flex items-center gap-3">
              <span class="text-sm">👥</span>
              <span>Kelola Member</span>
            </div>
            <span class="text-xs text-slate-600">›</span>
          </NuxtLink>

          <NuxtLink
            to="/petugas/laporan/member"
            class="flex items-center justify-between px-3.5 py-2.5 rounded-xl hover:bg-slate-800/40 hover:text-white text-xs font-semibold transition"
          >
            <div class="flex items-center gap-3">
              <span class="text-sm">📊</span>
              <span>Laporan</span>
            </div>
            <span class="text-xs text-slate-600">›</span>
          </NuxtLink>

          <NuxtLink
            to="/petugas/markir"
            class="flex items-center justify-between px-3.5 py-2.5 rounded-xl hover:bg-slate-800/40 hover:text-white text-xs font-semibold transition"
          >
            <div class="flex items-center gap-3">
              <span class="text-sm">🅿️</span>
              <span>Sedang Parkir</span>
            </div>
            <span class="text-[10px] bg-indigo-600/30 text-indigo-400 border border-indigo-500/30 px-2 py-0.5 rounded-full font-bold">
              {{ stats.sedang_parkir || 0 }}
            </span>
          </NuxtLink>
        </nav>
      </div>

      <div class="space-y-3 pt-4 border-t border-slate-800/80">
        <div class="bg-slate-900/80 border border-slate-800 px-3.5 py-2.5 rounded-xl flex items-center gap-3">
          <div class="w-7 h-7 rounded-lg bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-xs font-bold">
            P
          </div>
          <div class="min-w-0 flex-1">
            <p class="text-xs font-bold text-white truncate">Petugas Parkir</p>
            <p class="text-[10px] text-emerald-400 font-medium">Sistem Aktif</p>
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

    <main class="flex-1 flex flex-col min-w-0 h-screen overflow-y-auto">
      <header class="bg-white px-7 py-4 flex items-center justify-between border-b border-slate-100 shrink-0">
        <div>
          <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Plaza Andalas System</span>
          <h1 class="text-lg font-extrabold text-slate-900 tracking-tight">Dashboard Overview</h1>
        </div>

        <div class="flex items-center gap-3">
          <div class="bg-slate-100 p-0.5 rounded-full flex items-center text-xs font-bold text-slate-500">
            <button
              @click="timeFilter = 'today'"
              :class="timeFilter === 'today' ? 'bg-[#0B0F19] text-white shadow-xs' : 'hover:text-slate-900'"
              class="px-3.5 py-1.5 rounded-full transition cursor-pointer"
            >
              Hari Ini
            </button>
            <button
              @click="timeFilter = 'week'"
              :class="timeFilter === 'week' ? 'bg-[#0B0F19] text-white shadow-xs' : 'hover:text-slate-900'"
              class="px-3.5 py-1.5 rounded-full transition cursor-pointer"
            >
              Minggu Ini
            </button>
            <button
              @click="timeFilter = 'month'"
              :class="timeFilter === 'month' ? 'bg-[#0B0F19] text-white shadow-xs' : 'hover:text-slate-900'"
              class="px-3.5 py-1.5 rounded-full transition cursor-pointer"
            >
              Bulan Ini
            </button>
          </div>

          <NuxtLink
            to="/petugas/user"
            class="bg-cyan-600 hover:bg-cyan-700 text-white font-bold text-xs px-4 py-2 rounded-xl flex items-center gap-1.5 shadow-xs transition cursor-pointer"
          >
            <span>+</span>
            <span>Gate Masuk</span>
          </NuxtLink>
        </div>
      </header>

      <div class="p-7 space-y-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
          <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-xs flex flex-col justify-between">
            <div class="flex items-center justify-between mb-3">
              <div class="flex items-center gap-1.5">
                <span class="w-6 h-6 rounded-md bg-indigo-600 text-white flex items-center justify-center text-xs font-bold">💰</span>
                <span class="text-xs font-bold text-slate-700">Total Pendapatan</span>
              </div>
              <span class="text-[10px] font-bold text-emerald-500">↑ 38.21%</span>
            </div>
            <div>
              <h3 class="text-xl font-black text-slate-900 tracking-tight">
                Rp {{ formatRupiah(stats.pendapatan_hari_ini || 0) }}
              </h3>
              <div class="flex items-center justify-between text-[10px] text-slate-400 mt-2">
                <span>Periode Transaksi</span>
                <span class="font-bold text-slate-700 capitalize">{{ timeFilter }}</span>
              </div>
            </div>
          </div>

          <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-xs flex flex-col justify-between">
            <div class="flex items-center justify-between mb-3">
              <div class="flex items-center gap-1.5">
                <span class="w-6 h-6 rounded-md bg-sky-500 text-white flex items-center justify-center text-xs">🚗</span>
                <span class="text-xs font-bold text-slate-700">Sedang Parkir</span>
              </div>
              <span class="text-[10px] font-bold text-emerald-500">Live Sync</span>
            </div>
            <div>
              <h3 class="text-xl font-black text-slate-900 tracking-tight">
                {{ stats.sedang_parkir || 0 }} Unit
              </h3>
              <div class="flex items-center justify-between text-[10px] text-slate-400 mt-2">
                <span>Total Kendaraan Aktif</span>
                <NuxtLink to="/petugas/markir" class="font-bold text-indigo-600 hover:underline">Lihat Area ›</NuxtLink>
              </div>
            </div>
          </div>

          <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-xs flex flex-col justify-between">
            <div class="flex items-center justify-between mb-3">
              <div class="flex items-center gap-1.5">
                <span class="w-6 h-6 rounded-md bg-teal-500 text-white flex items-center justify-center text-xs">📊</span>
                <span class="text-xs font-bold text-slate-700">Kendaraan Masuk</span>
              </div>
              <span class="text-[10px] font-bold text-emerald-500">↑ 28.21%</span>
            </div>
            <div>
              <h3 class="text-xl font-black text-slate-900 tracking-tight">
                {{ stats.kendaraan_hari_ini || 0 }} Tiket
              </h3>
              <div class="flex items-center justify-between text-[10px] text-slate-400 mt-2">
                <span>Total Pos Masuk</span>
                <span class="font-bold text-slate-700">Gate Terdata</span>
              </div>
            </div>
          </div>

          <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-xs flex flex-col justify-between">
            <div class="flex items-center justify-between mb-3">
              <div class="flex items-center gap-1.5">
                <span class="w-6 h-6 rounded-md bg-amber-500 text-white flex items-center justify-center text-xs">👥</span>
                <span class="text-xs font-bold text-slate-700">Member Aktif</span>
              </div>
            </div>
            <div class="grid grid-cols-2 gap-2">
              <div>
                <p class="text-sm font-black text-slate-900">{{ stats.member_aktif || 0 }} Org</p>
                <p class="text-[9px] text-slate-400">Terdaftar</p>
              </div>
              <div>
                <p class="text-sm font-black text-slate-900">Lunas</p>
                <p class="text-[9px] text-emerald-500 font-bold">Status Member</p>
              </div>
            </div>
          </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-xs">
          <div class="flex items-center justify-between mb-5">
            <div class="bg-slate-100 p-0.5 rounded-lg flex items-center text-xs font-bold">
              <button
                @click="chartMode = 'bar'"
                :class="chartMode === 'bar' ? 'bg-cyan-600 text-white' : 'text-slate-500'"
                class="px-3 py-1 rounded-md transition cursor-pointer"
              >
                Bar Chart
              </button>
              <button
                @click="chartMode = 'line'"
                :class="chartMode === 'line' ? 'bg-cyan-600 text-white' : 'text-slate-500'"
                class="px-3 py-1 rounded-md transition cursor-pointer"
              >
                Line Chart
              </button>
            </div>

            <div class="flex items-center gap-4 text-xs font-bold text-slate-600">
              <div class="flex items-center gap-1.5">
                <span class="w-2.5 h-2.5 rounded-xs bg-indigo-600"></span>
                <span>{{ datasetsByFilter.currentLabel }}</span>
              </div>
              <div class="flex items-center gap-1.5">
                <span class="w-2.5 h-2.5 rounded-xs bg-amber-500"></span>
                <span>{{ datasetsByFilter.previousLabel }}</span>
              </div>
            </div>
          </div>

          <div class="h-64 relative">
            <Line v-if="chartMode === 'line'" :data="chartData" :options="chartOptions" />
            <Bar v-else :data="chartData" :options="chartOptions" />
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
          <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-xs flex flex-col justify-between">
            <div class="flex items-center justify-between">
              <h3 class="text-xs font-bold text-slate-800">Distribusi Kendaraan Aktif</h3>
              <span class="text-[10px] bg-slate-100 font-bold px-2 py-0.5 rounded text-slate-600">Live</span>
            </div>

            <div class="py-5 flex flex-col items-center justify-center">
              <div class="relative w-40 h-20 overflow-hidden flex items-end justify-center">
                <div class="w-40 h-40 rounded-full border-[12px] border-indigo-600 border-b-transparent border-l-rose-500 border-t-amber-400 rotate-[-45deg]"></div>
                <div class="absolute bottom-0 flex flex-col items-center">
                  <span class="text-2xl font-black text-slate-900 leading-none">{{ stats.sedang_parkir || 0 }}</span>
                  <span class="text-[9px] text-slate-400 font-bold mt-0.5 uppercase">Unit di Lokasi</span>
                </div>
              </div>
            </div>

            <div class="flex items-center justify-center gap-3 pt-3 border-t border-slate-50 text-[10px] font-bold text-slate-500">
              <div class="flex items-center gap-1">
                <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                <span>Non-Member</span>
              </div>
              <div class="flex items-center gap-1">
                <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                <span>Member</span>
              </div>
            </div>
          </div>

          <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-xs flex flex-col justify-between">
            <div class="flex items-center justify-between">
              <h3 class="text-xs font-bold text-slate-800">Kapasitas Sensor Gate</h3>
              <span class="text-emerald-500 font-bold text-[10px]">Normal</span>
            </div>

            <div class="flex items-center justify-between py-4">
              <div class="space-y-1 text-[11px] text-slate-600 font-medium">
                <p>Gate Masuk 1: <strong class="text-indigo-600">Aktif</strong></p>
                <p>Gate Masuk 2: <strong class="text-amber-500">Aktif</strong></p>
                <p>Gate Kasir Keluar: <strong class="text-teal-500">Standby</strong></p>
              </div>

              <div class="relative w-24 h-24 flex items-center justify-center">
                <div class="absolute inset-0 rounded-full border-[3px] border-indigo-600 border-t-transparent rotate-45"></div>
                <div class="absolute inset-2 rounded-full border-[3px] border-amber-400 border-r-transparent rotate-90"></div>
                <div class="absolute inset-4 rounded-full border-[3px] border-teal-400 border-b-transparent"></div>
                <div class="flex flex-col items-center">
                  <span class="text-base font-black text-slate-900 leading-none">100%</span>
                  <span class="text-[8px] text-slate-400 font-bold">ONLINE</span>
                </div>
              </div>
            </div>

            <div class="pt-2.5 border-t border-slate-50 text-[10px] text-slate-400 text-center font-bold">Monitoring Palang Pintu Otomatis</div>
          </div>

          <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-xs flex flex-col justify-between">
            <div class="flex items-center justify-between">
              <h3 class="text-xs font-bold text-slate-800">Transaksi Kasir Keluar</h3>
              <NuxtLink to="/petugas/transaksi" class="text-indigo-600 font-bold text-[10px] hover:underline">Semua ›</NuxtLink>
            </div>

            <div class="space-y-2 py-2">
              <div v-if="aktivitasTerbaru.length === 0" class="text-center text-slate-400 text-xs py-4">
                Belum ada transaksi keluar.
              </div>
              <div
                v-for="item in aktivitasTerbaru.slice(0, 3)"
                :key="item.id"
                class="flex items-center justify-between p-2 rounded-xl bg-slate-50 text-[11px]"
              >
                <div class="truncate">
                  <span class="font-bold text-slate-800 block truncate">{{ item.plat_nomor || item.no_plat || item.kode_tiket }}</span>
                  <span class="text-[9px] text-slate-400">{{ formatWaktu(item.created_at) }}</span>
                </div>
                <span class="font-bold text-emerald-600 shrink-0">
                  Rp {{ formatRupiah(item.total_tarif || item.total_bayar) }}
                </span>
              </div>
            </div>

            <div class="pt-2.5 border-t border-slate-50 text-[10px] text-slate-400 text-center font-bold">Sinkronisasi Kasir Realtime</div>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>