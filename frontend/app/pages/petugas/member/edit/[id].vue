<template>
  <div class="min-h-screen bg-secure-light flex flex-col">
    <header class="bg-secure-dark text-white p-4 shadow flex justify-between items-center">
      <div class="flex items-center space-x-4">
        <NuxtLink to="/petugas/member/select" class="text-gray-300 hover:text-white">← Kembali</NuxtLink>
        <h1 class="text-xl font-bold">Perpanjang Member</h1>
      </div>
    </header>

    <main class="flex-1 p-8 flex justify-center items-start">
      <div class="bg-white rounded-lg shadow-xl p-8 max-w-xl w-full">
        <div v-if="memberData" class="space-y-6">
          <div class="bg-gray-100 p-4 rounded border">
            <p class="text-sm text-gray-500">Member: <strong class="text-gray-800">{{ memberData.nama }} ({{ memberData.plat_nomor }})</strong></p>
            <p class="text-sm text-gray-500 mt-1">Berakhir pada: <strong class="text-gray-800">{{ memberData.tanggal_berakhir }}</strong></p>
          </div>

          <form @submit.prevent="processExtend" class="space-y-6">
            <div>
              <label class="block text-sm font-medium text-gray-700">Perpanjang Untuk (Bulan)</label>
              <select v-model="durasiBulan" required class="mt-1 block w-full border border-gray-300 rounded p-3 text-lg">
                <option value="1">1 Bulan</option>
                <option value="3">3 Bulan</option>
                <option value="6">6 Bulan</option>
                <option value="12">1 Tahun</option>
              </select>
            </div>
            
            <div class="bg-yellow-50 border border-yellow-200 p-4 rounded">
              <label class="block text-sm font-medium text-gray-700">Total Biaya (Rp)</label>
              <div class="text-3xl font-bold text-secure-dark mt-1">Rp {{ formatCurrency(calculatedBiaya) }}</div>
            </div>

            <button type="submit" :disabled="loading" class="w-full bg-green-600 text-white font-bold py-3 px-4 rounded shadow hover:bg-green-700 disabled:opacity-50 text-lg">
              {{ loading ? 'Memproses...' : 'Proses Pembayaran & Perpanjang' }}
            </button>
          </form>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { useRuntimeConfig } from '#app'
import axios from 'axios'

const config = useRuntimeConfig()
const router = useRouter()
const route = useRoute()
const loading = ref(false)
const memberData = ref(null)

const durasiBulan = ref(1)
const tarifPerBulan = 150000

const calculatedBiaya = computed(() => {
  return durasiBulan.value * tarifPerBulan
})

const formatCurrency = (val) => Number(val).toLocaleString('id-ID')

onMounted(() => {
  const data = localStorage.getItem('extend_member_data')
  if (data) {
    memberData.value = JSON.parse(data)
  } else {
    router.push('/petugas/member/select')
  }
})

const processExtend = async () => {
  loading.value = true
  try {
    await axios.post(`${config.public.apiBase}/petugas/member/${route.params.id}/extend`, {
      durasi_bulan: durasiBulan.value,
      nominal: calculatedBiaya.value
    }, {
      headers: { Authorization: `Bearer ${localStorage.getItem('token')}` }
    })
    alert('Member berhasil diperpanjang!')
    localStorage.removeItem('extend_member_data')
    router.push('/petugas/dashboard')
  } catch (error) {
    alert(error.response?.data?.message || 'Gagal memperpanjang member.')
  } finally {
    loading.value = false
  }
}
</script>