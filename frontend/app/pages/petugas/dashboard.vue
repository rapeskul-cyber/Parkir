<template>
  <div class="min-h-screen bg-secure-light flex flex-col">
    <!-- Navbar -->
    <header class="bg-secure-dark text-white p-4 shadow flex justify-between items-center">
      <h1 class="text-xl font-bold">Secure<span class="text-secure-gold">Parking</span> - Pos Kasir</h1>
      <button @click="logout" class="text-red-400 hover:text-red-300">Logout</button>
    </header>

    <main class="flex-1 p-8">
      <h2 class="text-2xl font-bold text-gray-800 mb-6">Dashboard Petugas</h2>
      
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <NuxtLink to="/petugas/keluar" class="bg-white p-6 rounded-lg shadow border-l-4 border-blue-500 hover:shadow-lg transition flex flex-col items-center justify-center h-32">
          <span class="text-3xl mb-2">🚗</span>
          <span class="font-bold text-gray-700">Gate Masuk / Keluar</span>
        </NuxtLink>
        
        <NuxtLink to="/petugas/member/tambah" class="bg-white p-6 rounded-lg shadow border-l-4 border-green-500 hover:shadow-lg transition flex flex-col items-center justify-center h-32">
          <span class="text-3xl mb-2">👤</span>
          <span class="font-bold text-gray-700">Daftar Member Baru</span>
        </NuxtLink>

        <NuxtLink to="/petugas/member/select" class="bg-white p-6 rounded-lg shadow border-l-4 border-secure-gold hover:shadow-lg transition flex flex-col items-center justify-center h-32">
          <span class="text-3xl mb-2">🔄</span>
          <span class="font-bold text-gray-700">Cek / Perpanjang Member</span>
        </NuxtLink>
      </div>
    </main>
  </div>
</template>

<script setup>
import { useRouter } from 'vue-router'

const router = useRouter()

const logout = () => {
  localStorage.removeItem('token')
  localStorage.removeItem('user_role')
  router.push('/')
}
</script>