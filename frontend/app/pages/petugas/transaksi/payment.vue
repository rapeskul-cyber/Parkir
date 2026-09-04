<template>
  <div class="min-h-screen bg-secure-light flex flex-col items-center p-8">
    <div class="max-w-lg w-full bg-white rounded-lg shadow-xl p-8 border-t-8 border-secure-dark">
      <h2 class="text-2xl font-bold text-center mb-6 border-b pb-4">Pembayaran Parkir</h2>
      
      <div v-if="paymentData" class="space-y-4 text-gray-700">
        <div class="flex justify-between">
          <span>Kode Tiket</span>
          <span class="font-bold">{{ paymentData.tiket.kode_tiket }}</span>
        </div>
        <div class="flex justify-between">
          <span>Plat Nomor</span>
          <span class="font-bold uppercase">{{ paymentData.tiket.plat_nomor }}</span>
        </div>
        <div class="flex justify-between">
          <span>Kategori</span>
          <span class="font-bold capitalize">{{ paymentData.tiket.kategori }}</span>
        </div>
        <div class="flex justify-between">
          <span>Waktu Masuk</span>
          <span>{{ new Date(paymentData.tiket.waktu_masuk).toLocaleString() }}</span>
        </div>
        <div class="flex justify-between">
          <span>Durasi (Jam)</span>
          <span class="font-bold">{{ paymentData.durasi_jam }} Jam</span>
        </div>
        
        <div v-if="paymentData.is_member" class="bg-green-100 text-green-800 p-3 rounded text-center font-bold my-4">
          Status: Member Aktif (Gratis)
        </div>

        <div class="border-t pt-4 mt-4 text-xl">
          <div class="flex justify-between font-bold text-secure-dark">
            <span>Total Bayar</span>
            <span>Rp {{ formatCurrency(paymentData.total_bayar) }}</span>
          </div>
        </div>

        <form v-if="paymentData.total_bayar > 0" @submit.prevent="processPayment" class="mt-6 space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">Uang Diterima (Rp)</label>
            <input 
              v-model="uangDiterima" 
              type="number" 
              required 
              min="0"
              class="mt-1 block w-full text-xl font-bold rounded-md border-gray-300 shadow-sm p-3 border focus:border-secure-gold focus:ring focus:ring-secure-gold focus:ring-opacity-50"
            >
          </div>
          
          <div v-if="kembalian !== null" class="p-4 rounded text-center text-lg" :class="kembalian >= 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'">
            Kembalian: <span class="font-bold">Rp {{ formatCurrency(kembalian) }}</span>
          </div>

          <button 
            type="submit" 
            :disabled="kembalian < 0 || loading"
            class="w-full bg-secure-dark text-white font-bold py-3 px-4 rounded shadow hover:bg-gray-800 disabled:opacity-50 text-lg mt-4"
          >
            {{ loading ? 'Memproses...' : 'Proses Pembayaran' }}
          </button>
        </form>

        <div v-else class="mt-6">
           <button @click="processPayment" :disabled="loading" class="w-full bg-secure-gold text-secure-dark font-bold py-3 px-4 rounded shadow hover:bg-yellow-500 disabled:opacity-50 text-lg">
            {{ loading ? 'Memproses...' : 'Selesaikan Transaksi (Member)' }}
          </button>
        </div>

        <div v-if="transaksiSelesai" class="mt-6 text-center">
           <p class="text-green-600 font-bold mb-4">Transaksi Berhasil! Gate Terbuka.</p>
           <NuxtLink to="/petugas/keluar" class="text-blue-600 underline">Kembali ke Scanner</NuxtLink>
        </div>
      </div>
      <div v-else class="text-center text-red-500">
        Data pembayaran tidak ditemukan.
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import { useRouter } from 'vue-router'
import { useRuntimeConfig } from '#app'
import axios from 'axios'

const config = useRuntimeConfig()
const router = useRouter()

const paymentData = ref(null)
const uangDiterima = ref('')
const loading = ref(false)
const transaksiSelesai = ref(false)

onMounted(() => {
  const data = localStorage.getItem('payment_data')
  if (data) {
    paymentData.value = JSON.parse(data)
    if (paymentData.value.total_bayar === 0) {
      uangDiterima.value = 0
    }
  } else {
    router.push('/petugas/keluar')
  }
})

const kembalian = computed(() => {
  if (!uangDiterima.value || !paymentData.value) return null
  return Number(uangDiterima.value) - paymentData.value.total_bayar
})

const formatCurrency = (val) => Number(val).toLocaleString('id-ID')

const processPayment = async () => {
  loading.value = true
  try {
    await axios.post(`${config.public.apiBase}/petugas/gate/payment`, {
      kode_tiket: paymentData.value.tiket.kode_tiket,
      uang_diterima: uangDiterima.value
    }, {
      headers: { Authorization: `Bearer ${localStorage.getItem('token')}` }
    })
    
    transaksiSelesai.value = true
    localStorage.removeItem('payment_data')
  } catch (error) {
    alert(error.response?.data?.message || 'Gagal memproses pembayaran')
  } finally {
    loading.value = false
  }
}
</script>