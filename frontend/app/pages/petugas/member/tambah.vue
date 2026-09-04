<template>
  <div class="min-h-screen bg-secure-light flex flex-col">
    <header class="bg-secure-dark text-white p-4 shadow flex justify-between items-center">
      <div class="flex items-center space-x-4">
        <NuxtLink to="/petugas/dashboard" class="text-gray-300 hover:text-white">← Kembali</NuxtLink>
        <h1 class="text-xl font-bold">Pendaftaran Member Baru</h1>
      </div>
    </header>

    <main class="flex-1 p-8 flex justify-center">
      <div class="bg-white rounded-lg shadow-xl p-8 max-w-2xl w-full">
        <form @submit.prevent="registerMember" class="space-y-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
              <input v-model="form.nama" type="text" required class="mt-1 block w-full border border-gray-300 rounded p-2">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">No. Telepon / WA</label>
              <input v-model="form.no_telp" type="text" required class="mt-1 block w-full border border-gray-300 rounded p-2">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Plat Nomor Kendaraan</label>
              <input v-model="form.plat_nomor" type="text" required class="mt-1 block w-full border border-gray-300 rounded p-2 uppercase" placeholder="BA 1234 XY">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Durasi (Bulan)</label>
              <select v-model="form.durasi_bulan" required class="mt-1 block w-full border border-gray-300 rounded p-2">
                <option value="1">1 Bulan</option>
                <option value="3">3 Bulan</option>
                <option value="6">6 Bulan</option>
                <option value="12">1 Tahun</option>
              </select>
            </div>
            <div class="md:col-span-2 bg-gray-50 p-4 rounded border border-gray-200">
              <label class="block text-sm font-medium text-gray-700">Total Biaya (Rp)</label>
              <div class="text-2xl font-bold text-secure-dark mt-1">Rp {{ formatCurrency(calculatedBiaya) }}</div>
            </div>
          </div>

          <button type="submit" :disabled="loading" class="w-full bg-secure-gold text-secure-dark font-bold py-3 px-4 rounded shadow hover:bg-yellow-500 disabled:opacity-50">
            {{ loading ? 'Menyimpan...' : 'Daftarkan Member' }}
          </button>
        </form>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useRouter } from 'vue-router'
import { useRuntimeConfig } from '#app'
import axios from 'axios'

const config = useRuntimeConfig()
const router = useRouter()
const loading = ref(false)

const form = ref({
  nama: '',
  no_telp: '',
  plat_nomor: '',
  durasi_bulan: 1
})

const tarifPerBulan = 150000 // Asumsi tarif flat 150rb/bulan

const calculatedBiaya = computed(() => {
  return form.value.durasi_bulan * tarifPerBulan
})

const formatCurrency = (val) => Number(val).toLocaleString('id-ID')

const registerMember = async () => {
  loading.value = true
  try {
    await axios.post(`${config.public.apiBase}/petugas/member/register`, {
      ...form.value,
      nominal: calculatedBiaya.value
    }, {
      headers: { Authorization: `Bearer ${localStorage.getItem('token')}` }
    })
    alert('Member berhasil didaftarkan!')
    router.push('/petugas/dashboard')
  } catch (error) {
    alert(error.response?.data?.message || 'Gagal mendaftar member. Pastikan plat nomor belum terdaftar.')
  } finally {
    loading.value = false
  }
}
</script>