<template>
  <div class="min-h-screen bg-secure-light flex flex-col">
    <header class="bg-secure-dark text-white p-4 shadow flex justify-between items-center">
      <div class="flex items-center space-x-4">
        <NuxtLink to="/petugas/dashboard" class="text-gray-300 hover:text-white">← Kembali</NuxtLink>
        <h1 class="text-xl font-bold">Gate Operation</h1>
      </div>
    </header>

    <main class="flex-1 p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
      <!-- Gate Masuk -->
      <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold mb-4 border-b pb-2 border-gray-200">Kendaraan Masuk</h2>
        <form @submit.prevent="handleMasuk" class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">Plat Nomor</label>
            <input v-model="formMasuk.plat_nomor" type="text" required class="mt-1 block w-full border border-gray-300 rounded p-2 uppercase" placeholder="BA 1234 XY">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Kategori</label>
            <select v-model="formMasuk.kategori" required class="mt-1 block w-full border border-gray-300 rounded p-2">
              <option value="motor">Motor</option>
              <option value="mobil">Mobil</option>
            </select>
          </div>
          <button type="submit" :disabled="loadingMasuk" class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded hover:bg-blue-700 disabled:opacity-50">
            {{ loadingMasuk ? 'Memproses...' : 'Cetak Tiket Masuk' }}
          </button>
        </form>
        <div v-if="tiketMasukResult" class="mt-4 p-4 bg-green-50 border border-green-200 rounded">
          <p class="text-green-800 font-bold">Tiket Berhasil Dibuat!</p>
          <p class="text-sm">Kode: <strong>{{ tiketMasukResult.kode_tiket }}</strong></p>
          <p class="text-sm">Waktu: {{ new Date(tiketMasukResult.waktu_masuk).toLocaleString() }}</p>
        </div>
      </div>

      <!-- Gate Keluar -->
      <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold mb-4 border-b pb-2 border-gray-200">Kendaraan Keluar</h2>
        <form @submit.prevent="handleKeluar" class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">Kode Tiket (Scan Barcode)</label>
            <input v-model="formKeluar.kode_tiket" type="text" required class="mt-1 block w-full border border-gray-300 rounded p-2" placeholder="TK-XXXXXX" autofocus>
          </div>
          <button type="submit" :disabled="loadingKeluar" class="w-full bg-secure-gold text-secure-dark font-bold py-2 px-4 rounded hover:bg-yellow-500 disabled:opacity-50">
            {{ loadingKeluar ? 'Mencari...' : 'Proses Tiket Keluar' }}
          </button>
        </form>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useRuntimeConfig } from '#app'
import axios from 'axios'

const config = useRuntimeConfig()
const router = useRouter()

const formMasuk = ref({ plat_nomor: '', kategori: 'motor' })
const loadingMasuk = ref(false)
const tiketMasukResult = ref(null)

const formKeluar = ref({ kode_tiket: '' })
const loadingKeluar = ref(false)

const getToken = () => localStorage.getItem('token')

const handleMasuk = async () => {
  loadingMasuk.value = true
  tiketMasukResult.value = null
  try {
    const res = await axios.post(`${config.public.apiBase}/petugas/gate/masuk`, formMasuk.value, {
      headers: { Authorization: `Bearer ${getToken()}` }
    })
    tiketMasukResult.value = res.data.tiket
    formMasuk.value.plat_nomor = ''
  } catch (error) {
    alert(error.response?.data?.message || 'Gagal membuat tiket masuk')
  } finally {
    loadingMasuk.value = false
  }
}

const handleKeluar = async () => {
  loadingKeluar.value = true
  try {
    const res = await axios.post(`${config.public.apiBase}/petugas/gate/keluar`, formKeluar.value, {
      headers: { Authorization: `Bearer ${getToken()}` }
    })
    // Store data in localStorage to pass to payment page (or use Pinia in real scenario)
    localStorage.setItem('payment_data', JSON.stringify(res.data))
    router.push('/petugas/transaksi/payment')
  } catch (error) {
    alert(error.response?.data?.message || 'Tiket tidak valid')
  } finally {
    loadingKeluar.value = false
  }
}
</script>