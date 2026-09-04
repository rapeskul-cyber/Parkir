<template>
  <div class="min-h-screen bg-secure-light flex">
    <!-- Sidebar (Same as dashboard) -->
    <aside class="w-64 bg-secure-dark text-white hidden md:block">
      <div class="p-6">
        <h2 class="text-2xl font-bold">Secure<span class="text-secure-gold">Parking</span></h2>
      </div>
      <nav class="mt-6 px-4 space-y-2">
        <NuxtLink to="/admin/dashboard" class="block py-2 px-4 rounded hover:bg-gray-800 transition">Dashboard</NuxtLink>
        <NuxtLink to="/admin/petugas" class="block py-2 px-4 rounded bg-secure-gold text-secure-dark font-semibold">Manajemen Petugas</NuxtLink>
        <div class="pt-4 pb-2 text-xs font-semibold text-gray-400 uppercase">Laporan</div>
        <NuxtLink to="/admin/laporan/member" class="block py-2 px-4 rounded hover:bg-gray-800 transition">Laporan Member</NuxtLink>
        <NuxtLink to="/admin/laporan/non-member" class="block py-2 px-4 rounded hover:bg-gray-800 transition">Laporan Transaksi</NuxtLink>
      </nav>
    </aside>

    <main class="flex-1 p-8">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Manajemen Petugas</h1>
        <button @click="openModal()" class="bg-secure-dark text-white px-4 py-2 rounded shadow hover:bg-gray-800">Tambah Petugas</button>
      </div>

      <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="p in petugas" :key="p.id">
              <td class="px-6 py-4 whitespace-nowrap">{{ p.name }}</td>
              <td class="px-6 py-4 whitespace-nowrap">{{ p.email }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <button @click="openModal(p)" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</button>
                <button @click="deletePetugas(p.id)" class="text-red-600 hover:text-red-900">Hapus</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Modal -->
      <div v-if="showModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-xl w-96">
          <h2 class="text-xl font-bold mb-4">{{ isEdit ? 'Edit Petugas' : 'Tambah Petugas' }}</h2>
          <form @submit.prevent="savePetugas" class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-gray-700">Nama</label>
              <input v-model="form.name" type="text" required class="mt-1 block w-full rounded border-gray-300 border p-2">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Email</label>
              <input v-model="form.email" type="email" required class="mt-1 block w-full rounded border-gray-300 border p-2">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Password <span v-if="isEdit" class="text-xs text-gray-500">(Kosongkan jika tidak diubah)</span></label>
              <input v-model="form.password" type="password" :required="!isEdit" class="mt-1 block w-full rounded border-gray-300 border p-2">
            </div>
            <div class="flex justify-end space-x-3 mt-6">
              <button type="button" @click="showModal = false" class="px-4 py-2 text-gray-600 hover:text-gray-800">Batal</button>
              <button type="submit" class="px-4 py-2 bg-secure-gold text-secure-dark font-bold rounded shadow hover:bg-yellow-400">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRuntimeConfig } from '#app'
import axios from 'axios'

const config = useRuntimeConfig()
const petugas = ref([])
const showModal = ref(false)
const isEdit = ref(false)
const form = ref({ id: null, name: '', email: '', password: '' })

const getToken = () => localStorage.getItem('token')

const fetchPetugas = async () => {
  try {
    const res = await axios.get(`${config.public.apiBase}/admin/petugas`, {
      headers: { Authorization: `Bearer ${getToken()}` }
    })
    petugas.value = res.data
  } catch (error) {
    console.error(error)
  }
}

const openModal = (p = null) => {
  if (p) {
    isEdit.value = true
    form.value = { id: p.id, name: p.name, email: p.email, password: '' }
  } else {
    isEdit.value = false
    form.value = { id: null, name: '', email: '', password: '' }
  }
  showModal.value = true
}

const savePetugas = async () => {
  try {
    const headers = { Authorization: `Bearer ${getToken()}` }
    if (isEdit.value) {
      const payload = { name: form.value.name, email: form.value.email }
      if (form.value.password) payload.password = form.value.password
      await axios.put(`${config.public.apiBase}/admin/petugas/${form.value.id}`, payload, { headers })
    } else {
      await axios.post(`${config.public.apiBase}/admin/petugas`, form.value, { headers })
    }
    showModal.value = false
    fetchPetugas()
  } catch (error) {
    alert(error.response?.data?.message || 'Terjadi kesalahan')
  }
}

const deletePetugas = async (id) => {
  if (confirm('Yakin ingin menghapus petugas ini?')) {
    try {
      await axios.delete(`${config.public.apiBase}/admin/petugas/${id}`, {
        headers: { Authorization: `Bearer ${getToken()}` }
      })
      fetchPetugas()
    } catch (error) {
      console.error(error)
    }
  }
}

onMounted(fetchPetugas)
</script>