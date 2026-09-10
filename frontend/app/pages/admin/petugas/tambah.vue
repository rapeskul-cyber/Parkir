<template>
  <div class="min-h-screen bg-[#F8FAFC] flex items-center justify-center p-5 font-sans antialiased text-slate-800">
    <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-xs w-full max-w-[460px] space-y-6">
      
      <!-- Brand & Header Form -->
      <div class="text-center space-y-1">
        <div class="inline-flex items-center justify-center w-11 h-11 rounded-2xl bg-cyan-400 text-[#0B0F19] font-black text-lg mb-2 shadow-[0_0_15px_rgba(34,211,238,0.25)]">
          P
        </div>
        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">ADMINISTRATOR CONTROL</span>
        <h1 class="text-lg font-black text-slate-900 tracking-tight">Tambah Akun Baru</h1>
        <p class="text-xs text-slate-400">Buat kredensial akses untuk petugas pos atau admin.</p>
      </div>

      <!-- Input Fields -->
      <div class="space-y-4">
        <div>
          <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Lengkap</label>
          <input
            v-model="form.name"
            type="text"
            placeholder="Contoh: Rian Pratama"
            class="w-full bg-slate-50 border border-slate-200 focus:border-[#0284C7] focus:bg-white focus:ring-2 focus:ring-[#0284C7]/20 rounded-2xl px-4 py-3 text-xs font-bold text-slate-800 outline-none transition"
          />
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-700 mb-1.5">Alamat Email</label>
          <input
            v-model="form.email"
            type="email"
            placeholder="nama@parkir.com"
            class="w-full bg-slate-50 border border-slate-200 focus:border-[#0284C7] focus:bg-white focus:ring-2 focus:ring-[#0284C7]/20 rounded-2xl px-4 py-3 text-xs font-bold text-slate-800 outline-none transition"
          />
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-700 mb-1.5">Password</label>
          <input
            v-model="form.password"
            type="password"
            placeholder="Minimal 6 karakter"
            class="w-full bg-slate-50 border border-slate-200 focus:border-[#0284C7] focus:bg-white focus:ring-2 focus:ring-[#0284C7]/20 rounded-2xl px-4 py-3 text-xs font-bold text-slate-800 outline-none transition"
          />
        </div>

        <!-- Role Access -->
        <div>
          <label class="block text-xs font-bold text-slate-700 mb-1.5">Hak Akses (Role)</label>
          <div class="grid grid-cols-2 gap-2">
            <button
              type="button"
              @click="form.role = 'petugas'"
              class="p-3 rounded-2xl border text-xs font-extrabold flex flex-col items-center gap-1 transition cursor-pointer"
              :class="form.role === 'petugas' ? 'bg-[#0B0F19] text-white border-[#0B0F19] shadow-xs' : 'bg-slate-50 text-slate-600 border-slate-200 hover:bg-slate-100'"
            >
              <span>🚪 Petugas</span>
              <span class="text-[10px] font-normal opacity-80">Kasir & Gerbang</span>
            </button>
            <button
              type="button"
              @click="form.role = 'admin'"
              class="p-3 rounded-2xl border text-xs font-extrabold flex flex-col items-center gap-1 transition cursor-pointer"
              :class="form.role === 'admin' ? 'bg-[#0B0F19] text-white border-[#0B0F19] shadow-xs' : 'bg-slate-50 text-slate-600 border-slate-200 hover:bg-slate-100'"
            >
              <span>⚡ Admin</span>
              <span class="text-[10px] font-normal opacity-80">Full Control</span>
            </button>
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="pt-3 space-y-2">
          <button
            @click="simpanPetugas"
            :disabled="loading"
            type="button"
            class="w-full bg-[#0284C7] hover:bg-[#0369A1] disabled:bg-slate-300 text-white py-3.5 rounded-2xl font-black text-xs transition cursor-pointer shadow-xs uppercase tracking-wider"
          >
            {{ loading ? 'Menyimpan Akun...' : 'Simpan Akun Petugas' }}
          </button>
          
          <button
            @click="router.push('/admin/petugas')"
            type="button"
            class="w-full bg-slate-100 hover:bg-slate-200 text-slate-600 py-3 rounded-2xl font-bold text-xs transition cursor-pointer"
          >
            Kembali ke Daftar Petugas
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, reactive } from 'vue'

definePageMeta({ 
  middleware: ['auth', 'cek-admin'] 
})

const { $api } = useNuxtApp()
const router = useRouter()
const loading = ref(false)

const form = reactive({
  name: '',
  email: '',
  password: '',
  role: 'petugas'
})

const simpanPetugas = async () => {
  if (!form.name || !form.email || !form.password) {
    alert('Semua kolom wajib diisi!')
    return
  }

  if (form.password.length < 6) {
    alert('Password minimal 6 karakter!')
    return
  }

  loading.value = true
  try {
    await $api.post('/admin/petugas', form)
    router.push('/admin/petugas')
  } catch (err: any) {
    alert(err?.response?.data?.message || 'Gagal menyimpan akun.')
  } finally {
    loading.value = false
  }
}
</script>