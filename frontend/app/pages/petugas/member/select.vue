<template>
  <div class="min-h-screen bg-secure-light flex flex-col">
    <header class="bg-secure-dark text-white p-4 shadow flex justify-between items-center">
      <div class="flex items-center space-x-4">
        <NuxtLink to="/petugas/dashboard" class="text-gray-300 hover:text-white">← Kembali</NuxtLink>
        <h1 class="text-xl font-bold">Cek Status Member</h1>
      </div>
    </header>

    <main class="flex-1 p-8 flex justify-center items-start">
      <div class="bg-white rounded-lg shadow-xl p-8 max-w-xl w-full">
        <form @submit.prevent="checkMember" class="mb-8">
          <label class="block text-sm font-medium text-gray-700 mb-2">Masukkan Plat Nomor Kendaraan</label>
          <div class="flex space-x-2">
            <input v-model="platNomor" type="text" required class="flex-1 border border-gray-300 rounded p-3 uppercase text-xl" placeholder="BA 1234 XY">
            <button type="submit" :disabled="loading" class="bg-blue-600 text-white font-bold px-6 py-3 rounded hover:bg-blue-700 disabled:opacity-50">Cek</button>
          </div>
        </form>

        <div v-if="memberData" class="border-t pt-6">
          <h3 class="text-lg font-bold mb-4">Informasi Member</h3>
          <div class="space-y-3 mb-6 bg-gray-50 p-4 rounded border">
            <div class="flex justify-between">
              <span class="text-gray-600">Nama</span>
              <span class="font-semibold">{{ memberData.nama }}</span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-600">Plat Nomor</span>
              <span class="font-semibold uppercase">{{ memberData.plat_nomor }}</span>
            </div>
            <div class="flex justify-between items-center">
              <span class="text-gray-600">Status</span>
              <span class="px-2 py-1 rounded text-xs font-bold" :class="isExpired ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800'">
                {{ isExpired ? 'EXPIRED' : 'AKTIF' }}
              </span>
            </div>
            <div class="flex justify-between text-sm">
              <span class="text-gray-600">Tgl Berakhir</span>
              <span class="font-bold" :class="{'text-red-600': isExpired}">{{ memberData.tanggal_berakhir }}</span>
            </div>
          </div>

          <button @click="goToExtend" class="w-full bg-secure-gold text-secure-dark font-bold py-3 px-4 rounded shadow hover:bg-yellow-500">
            Perpanjang Member
          </button>
        </div>
        
        <div v-if="errorMsg" class="mt-4 p-4 bg-red-50 text-red-600 border border-red-200 rounded text-center">
          {{ errorMsg }}
        </div>
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
const platNomor = ref('')
const loading = ref(false)
const memberData = ref(null)
const errorMsg = ref('')

const isExpired = computed(() => {
  if (!memberData.value) return false
  const end = new Date(memberData.value.tanggal_berakhir)
  const today = new Date()
  today.setHours(0,0,0,0)
  return end < today
})

const checkMember = async () => {
  loading.value = true
  errorMsg.value = ''
  memberData.value = null
  try {
    const res = await axios.post(`${config.public.apiBase}/petugas/member/check`, { plat_nomor: platNomor.value }, {
      headers: { Authorization: `Bearer ${localStorage.getItem('token')}` }
    })
    memberData.value = res.data
  } catch (error) {
    errorMsg.value = error.response?.data?.message || 'Member tidak ditemukan.'
  } finally {
    loading.value = false
  }
}

const goToExtend = () => {
  // Pass member data via localStorage or Pinia (simplified with localStorage here)
  localStorage.setItem('extend_member_data', JSON.stringify(memberData.value))
  router.push(`/petugas/member/edit/${memberData.value.id}`)
}
</script>