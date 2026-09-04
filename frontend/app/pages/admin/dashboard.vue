<template>
  <div class="min-h-screen bg-secure-light flex">
    <!-- Sidebar -->
    <aside class="w-64 bg-secure-dark text-white hidden md:block">
      <div class="p-6">
        <h2 class="text-2xl font-bold">Secure<span class="text-secure-gold">Parking</span></h2>
        <p class="text-xs text-gray-400 mt-1">Super Admin Panel</p>
      </div>
      <nav class="mt-6 px-4 space-y-2">
        <NuxtLink to="/admin/dashboard" class="block py-2 px-4 rounded bg-secure-gold text-secure-dark font-semibold">Dashboard</NuxtLink>
        <NuxtLink to="/admin/petugas" class="block py-2 px-4 rounded hover:bg-gray-800 transition">Manajemen Petugas</NuxtLink>
        <div class="pt-4 pb-2 text-xs font-semibold text-gray-400 uppercase">Laporan</div>
        <NuxtLink to="/admin/laporan/member" class="block py-2 px-4 rounded hover:bg-gray-800 transition">Laporan Member</NuxtLink>
        <NuxtLink to="/admin/laporan/non-member" class="block py-2 px-4 rounded hover:bg-gray-800 transition">Laporan Transaksi</NuxtLink>
        <button @click="logout" class="w-full text-left mt-8 py-2 px-4 rounded text-red-400 hover:bg-gray-800 transition">Logout</button>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8 overflow-y-auto">
      <div class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
        <div class="text-sm text-gray-500">Live sync: <span class="text-green-500 font-semibold">Active</span></div>
      </div>

      <div v-if="stats" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-secure-gold">
          <p class="text-sm text-gray-500 mb-1">Pendapatan Hari Ini</p>
          <p class="text-2xl font-bold text-secure-dark">Rp {{ formatCurrency(stats.pendapatan_hari_ini) }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
          <p class="text-sm text-gray-500 mb-1">Tiket Masuk (Hari Ini)</p>
          <p class="text-2xl font-bold text-secure-dark">{{ stats.tiket_masuk_hari_ini }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
          <p class="text-sm text-gray-500 mb-1">Member Aktif</p>
          <p class="text-2xl font-bold text-secure-dark">{{ stats.member_aktif }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-red-500">
          <p class="text-sm text-gray-500 mb-1">Kendaraan Parkir (Live)</p>
          <p class="text-2xl font-bold text-secure-dark">{{ stats.kendaraan_parkir }}</p>
        </div>
      </div>

      <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-bold mb-4">Grafik Pendapatan 7 Hari Terakhir</h3>
        <div class="h-64 flex items-end space-x-2">
          <!-- Placeholder for Chart.js to keep it simple visually if module not fully mounted -->
          <div v-if="stats" class="w-full flex h-full items-end justify-between border-b border-gray-200 pb-2 relative">
             <div v-for="(val, i) in stats.chart_data.pendapatan" :key="i" class="w-1/8 flex flex-col items-center">
                <div class="w-8 bg-secure-gold rounded-t" :style="{ height: getChartHeight(val) + '%' }"></div>
                <div class="text-xs text-gray-500 mt-2 transform -rotate-45 origin-top-left">{{ stats.chart_data.labels[i] }}</div>
             </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { useRouter } from 'vue-router'
import { useRuntimeConfig } from '#app'
import axios from 'axios'

const router = useRouter()
const config = useRuntimeConfig()
const stats = ref(null)
let syncInterval

const fetchStats = async () => {
  try {
    const token = localStorage.getItem('token')
    const response = await axios.get(`${config.public.apiBase}/admin/dashboard`, {
      headers: { Authorization: `Bearer ${token}` }
    })
    stats.value = response.data
  } catch (error) {
    if (error.response?.status === 401 || error.response?.status === 403) {
      router.push('/')
    }
  }
}

const formatCurrency = (val) => {
  return Number(val).toLocaleString('id-ID')
}

const getChartHeight = (val) => {
  if (!stats.value || !stats.value.chart_data.pendapatan.length) return 0
  const max = Math.max(...stats.value.chart_data.pendapatan) || 1
  return (val / max) * 100
}

const logout = () => {
  localStorage.removeItem('token')
  localStorage.removeItem('user_role')
  router.push('/')
}

onMounted(() => {
  fetchStats()
  // Live sync every 5 seconds as requested
  syncInterval = setInterval(fetchStats, 5000)
})

onUnmounted(() => {
  clearInterval(syncInterval)
})
</script>