<template>
  <div class="min-h-screen bg-secure-light flex">
    <aside class="w-64 bg-secure-dark text-white hidden md:block">
      <div class="p-6"><h2 class="text-2xl font-bold">Secure<span class="text-secure-gold">Parking</span></h2></div>
      <nav class="mt-6 px-4 space-y-2">
        <NuxtLink to="/admin/dashboard" class="block py-2 px-4 rounded hover:bg-gray-800 transition">Dashboard</NuxtLink>
        <NuxtLink to="/admin/petugas" class="block py-2 px-4 rounded hover:bg-gray-800 transition">Manajemen Petugas</NuxtLink>
        <div class="pt-4 pb-2 text-xs font-semibold text-gray-400 uppercase">Laporan</div>
        <NuxtLink to="/admin/laporan/member" class="block py-2 px-4 rounded hover:bg-gray-800 transition">Laporan Member</NuxtLink>
        <NuxtLink to="/admin/laporan/non-member" class="block py-2 px-4 rounded bg-secure-gold text-secure-dark font-semibold">Laporan Transaksi</NuxtLink>
      </nav>
    </aside>

    <main class="flex-1 p-8">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Laporan Transaksi Kasir</h1>
        <button @click="printLaporan" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">Cetak Laporan</button>
      </div>

      <div class="bg-white p-4 rounded shadow mb-6 flex space-x-4 items-end">
        <div>
          <label class="block text-sm font-medium text-gray-700">Mulai Tanggal</label>
          <input v-model="filter.start_date" type="date" class="mt-1 border rounded p-2">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Sampai Tanggal</label>
          <input v-model="filter.end_date" type="date" class="mt-1 border rounded p-2">
        </div>
        <button @click="fetchLaporan" class="bg-secure-dark text-white px-4 py-2 rounded hover:bg-gray-800">Filter</button>
      </div>

      <div class="bg-white rounded-lg shadow overflow-hidden" id="print-area">
        <div class="print-only hidden mb-4 text-center">
          <h2 class="text-2xl font-bold">Laporan Transaksi SecureParking</h2>
          <p>Periode: {{ filter.start_date || '-' }} s/d {{ filter.end_date || '-' }}</p>
        </div>
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Waktu</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode Tiket</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Plat Nomor</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Durasi (Jam)</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Bayar</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kasir</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="t in transaksi" :key="t.id">
              <td class="px-6 py-4 whitespace-nowrap">{{ new Date(t.created_at).toLocaleString() }}</td>
              <td class="px-6 py-4 whitespace-nowrap">{{ t.kode_tiket || '-' }}</td>
              <td class="px-6 py-4 whitespace-nowrap">{{ t.plat_nomor }}</td>
              <td class="px-6 py-4 whitespace-nowrap">{{ t.durasi_jam }}</td>
              <td class="px-6 py-4 whitespace-nowrap">Rp {{ formatCurrency(t.total_bayar) }}</td>
              <td class="px-6 py-4 whitespace-nowrap">{{ t.kasir?.name || 'Unknown' }}</td>
            </tr>
          </tbody>
          <tfoot class="bg-gray-50">
            <tr>
              <td colspan="4" class="px-6 py-4 text-right font-bold">Total Pendapatan:</td>
              <td colspan="2" class="px-6 py-4 font-bold text-secure-dark">Rp {{ formatCurrency(totalPendapatan) }}</td>
            </tr>
          </tfoot>
        </table>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRuntimeConfig } from '#app'
import axios from 'axios'

const config = useRuntimeConfig()
const transaksi = ref([])
const filter = ref({ start_date: '', end_date: '' })

const fetchLaporan = async () => {
  try {
    let url = `${config.public.apiBase}/admin/laporan/non-member`
    if (filter.value.start_date && filter.value.end_date) {
      url += `?start_date=${filter.value.start_date}&end_date=${filter.value.end_date}`
    }
    const res = await axios.get(url, {
      headers: { Authorization: `Bearer ${localStorage.getItem('token')}` }
    })
    transaksi.value = res.data
  } catch (error) {
    console.error(error)
  }
}

const totalPendapatan = computed(() => {
  return transaksi.value.reduce((sum, t) => sum + Number(t.total_bayar), 0)
})

const formatCurrency = (val) => Number(val).toLocaleString('id-ID')

const printLaporan = () => {
  window.print()
}

onMounted(fetchLaporan)
</script>

<style>
@media print {
  body * { visibility: hidden; }
  #print-area, #print-area * { visibility: visible; }
  #print-area { position: absolute; left: 0; top: 0; width: 100%; }
  .print-only { display: block !important; }
}
</style>