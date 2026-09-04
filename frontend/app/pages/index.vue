<template>
  <div class="min-h-screen bg-secure-light flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-white rounded-lg shadow-lg p-8">
      <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-secure-dark">Secure<span class="text-secure-gold">Parking</span></h1>
        <p class="text-gray-500 mt-2">Masuk ke sistem manajemen parkir</p>
      </div>

      <form @submit.prevent="handleLogin" class="space-y-6">
        <div>
          <label class="block text-sm font-medium text-gray-700">Email</label>
          <input 
            v-model="form.email" 
            type="email" 
            required 
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-secure-gold focus:ring focus:ring-secure-gold focus:ring-opacity-50 p-2 border"
            placeholder="admin@example.com"
          >
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Password</label>
          <input 
            v-model="form.password" 
            type="password" 
            required 
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-secure-gold focus:ring focus:ring-secure-gold focus:ring-opacity-50 p-2 border"
          >
        </div>

        <div v-if="errorMsg" class="text-red-500 text-sm text-center">
          {{ errorMsg }}
        </div>

        <button 
          type="submit" 
          :disabled="isLoading"
          class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-secure-dark hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secure-dark disabled:opacity-50"
        >
          {{ isLoading ? 'Loading...' : 'Masuk' }}
        </button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useRuntimeConfig } from '#app'
import axios from 'axios'

const router = useRouter()
const config = useRuntimeConfig()

const form = ref({
  email: '',
  password: ''
})
const isLoading = ref(false)
const errorMsg = ref('')

const handleLogin = async () => {
  isLoading.value = true
  errorMsg.value = ''
  
  try {
    const response = await axios.post(`${config.public.apiBase}/login`, form.value)
    const data = response.data
    
    // Store token and role (in a real app, use Pinia + useCookie)
    localStorage.setItem('token', data.access_token)
    localStorage.setItem('user_role', data.user.role)
    
    // Set default axios header
    axios.defaults.headers.common['Authorization'] = `Bearer ${data.access_token}`
    
    if (data.user.role === 'admin') {
      router.push('/admin/dashboard')
    } else {
      router.push('/petugas/dashboard')
    }
  } catch (error) {
    errorMsg.value = error.response?.data?.message || 'Login gagal. Silakan periksa kredensial Anda.'
  } finally {
    isLoading.value = false
  }
}
</script>