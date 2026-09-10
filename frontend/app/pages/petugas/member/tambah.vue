<template>
  <div class="min-h-screen bg-[#F8FAFC] flex font-sans antialiased text-slate-800">
    <!-- SIDEBAR PERSIS REFERENSI -->
    <aside class="w-64 bg-[#0B0F19] text-slate-400 flex flex-col justify-between py-6 px-4 shrink-0 select-none hidden md:flex">
      <div>
        <!-- Brand Header -->
        <div class="flex items-center justify-between px-2 mb-7">
          <div class="flex items-center gap-2.5">
            <div class="w-9 h-9 rounded-xl bg-cyan-400 text-[#0B0F19] flex items-center justify-center font-black text-base shadow-[0_0_15px_rgba(34,211,238,0.3)]">
              P
            </div>
            <div>
              <span class="text-base font-extrabold tracking-tight text-white block leading-none">PARKIR</span>
              <span class="text-[9px] text-slate-500 font-bold uppercase tracking-widest mt-0.5 block">PLAZA ANDALAS</span>
            </div>
          </div>
          <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
        </div>

        <!-- Menu Links -->
        <nav class="space-y-1">
          <NuxtLink
            to="/petugas"
            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/40 font-semibold text-xs transition"
          >
            <span class="text-sm">⊞</span>
            <span>Dashboard</span>
          </NuxtLink>

          <NuxtLink
            to="/petugas/user"
            class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/40 text-xs font-semibold transition"
          >
            <div class="flex items-center gap-3">
              <span class="text-sm">🟢</span>
              <span>Gate Masuk</span>
            </div>
            <span class="text-xs text-slate-600">›</span>
          </NuxtLink>

          <NuxtLink
            to="/petugas/keluar"
            class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/40 text-xs font-semibold transition"
          >
            <div class="flex items-center gap-3">
              <span class="text-sm">🚪</span>
              <span>Gate Keluar (Kasir)</span>
            </div>
            <span class="text-xs text-slate-600">›</span>
          </NuxtLink>

          <NuxtLink
            to="/petugas/transaksi"
            class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/40 text-xs font-semibold transition"
          >
            <div class="flex items-center gap-3">
              <span class="text-sm">🚗</span>
              <span>Kelola Transaksi</span>
            </div>
            <span class="text-xs text-slate-600">›</span>
          </NuxtLink>

          <NuxtLink
            to="/petugas/member/select"
            class="flex items-center justify-between px-3.5 py-2.5 rounded-xl bg-slate-800/90 text-white font-semibold text-xs shadow-xs"
          >
            <div class="flex items-center gap-3">
              <span class="text-sm text-cyan-400">👥</span>
              <span>Kelola Member</span>
            </div>
            <span class="text-xs text-cyan-400 font-bold">●</span>
          </NuxtLink>

          <NuxtLink
            to="/petugas/laporan/member"
            class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/40 text-xs font-semibold transition"
          >
            <div class="flex items-center gap-3">
              <span class="text-sm">📊</span>
              <span>Laporan</span>
            </div>
            <span class="text-xs text-slate-600">›</span>
          </NuxtLink>

          <NuxtLink
            to="/petugas/markir"
            class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/40 text-xs font-semibold transition"
          >
            <div class="flex items-center gap-3">
              <span class="text-sm">🅿️</span>
              <span>Sedang Parkir</span>
            </div>
            <span class="text-xs text-slate-600">›</span>
          </NuxtLink>
        </nav>
      </div>

      <!-- Bottom Profile Card -->
      <div class="space-y-3 pt-4 border-t border-slate-800/80">
        <div class="bg-slate-900/90 border border-slate-800 px-3.5 py-2.5 rounded-2xl flex items-center gap-3">
          <div class="w-8 h-8 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 flex items-center justify-center text-xs font-bold">
            P
          </div>
          <div class="min-w-0 flex-1">
            <p class="text-xs font-bold text-white truncate">Petugas Parkir</p>
            <p class="text-[10px] text-emerald-400 font-medium">Sistem Aktif</p>
          </div>
        </div>

        <button
          @click="logout"
          class="w-full flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold text-rose-400 hover:bg-rose-500/10 transition cursor-pointer"
        >
          <span>🚪</span>
          <span>Logout</span>
        </button>
      </div>
    </aside>

    <!-- CONTENT PANEL -->
    <main class="flex-1 flex flex-col min-w-0 h-screen overflow-y-auto">
      <!-- Top Bar Header -->
      <header class="bg-white px-8 py-5 flex items-center justify-between border-b border-slate-100 shrink-0">
        <div>
          <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">PLAZA ANDALAS SYSTEM</span>
          <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">Tambah Member Baru</h1>
        </div>

        <div class="flex items-center gap-3">
          <button
            @click="router.push('/petugas/member/select')"
            class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2 rounded-full text-xs font-bold transition flex items-center gap-1.5 cursor-pointer shadow-xs"
          >
            <span>←</span> Kembali ke Daftar
          </button>
        </div>
      </header>

      <!-- Main Form / Card Area -->
      <div class="p-8 flex justify-center items-start">
        <div class="w-full max-w-xl">
          <!-- FORM INPUT CARD -->
          <div v-if="!suksesData" class="bg-white rounded-3xl border border-slate-100 shadow-xs p-7">
            <div class="mb-6">
              <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">FORMULIR PENDAFTARAN</span>
              <h2 class="text-lg font-black text-slate-900 tracking-tight mt-0.5">Registrasi Langganan</h2>
              <p class="text-xs text-slate-400 mt-1">Isi identitas pengendara dan lakukan pembayaran member untuk 30 hari.</p>
            </div>

            <form @submit.prevent="submitForm" class="space-y-4">
              <!-- Nama Member -->
              <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Lengkap Member</label>
                <input
                  v-model="form.nama_member"
                  type="text"
                  placeholder="Contoh: Budi Santoso"
                  required
                  class="w-full bg-slate-50 border border-slate-200 focus:border-[#0284C7] focus:bg-white focus:ring-2 focus:ring-[#0284C7]/20 rounded-2xl px-4 py-3 text-xs font-semibold text-slate-800 outline-none transition"
                />
              </div>

              <!-- Nama Perusahaan -->
              <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Instansi / Perusahaan</label>
                <input
                  v-model="form.nama_perusahaan"
                  type="text"
                  placeholder="Contoh: PT. Maju Bersama / Umum"
                  required
                  class="w-full bg-slate-50 border border-slate-200 focus:border-[#0284C7] focus:bg-white focus:ring-2 focus:ring-[#0284C7]/20 rounded-2xl px-4 py-3 text-xs font-semibold text-slate-800 outline-none transition"
                />
              </div>

              <!-- Uang Bayar -->
              <div>
                <div class="flex items-center justify-between mb-1.5">
                  <label class="block text-xs font-bold text-slate-700">Nominal Pembayaran (Rp)</label>
                  <span class="text-[11px] font-bold text-slate-400">Tarif Standar: Rp 150.000</span>
                </div>
                <div class="relative">
                  <span class="absolute left-4 top-3 text-xs font-bold text-slate-400">Rp</span>
                  <input
                    v-model.number="form.uang_bayar"
                    type="number"
                    min="0"
                    placeholder="150000"
                    required
                    class="w-full bg-slate-50 border border-slate-200 focus:border-[#0284C7] focus:bg-white focus:ring-2 focus:ring-[#0284C7]/20 rounded-2xl pl-11 pr-4 py-3 text-xs font-black text-slate-800 outline-none transition"
                  />
                </div>
              </div>

              <!-- Submit Buttons -->
              <div class="pt-4 flex items-center gap-3">
                <button
                  type="submit"
                  :disabled="loading"
                  class="flex-1 bg-[#0284C7] hover:bg-[#0369A1] text-white py-3 rounded-2xl font-black text-xs transition cursor-pointer shadow-xs disabled:opacity-50"
                >
                  {{ loading ? 'Memproses Sistem...' : 'Simpan & Terbitkan Kartu' }}
                </button>
                <button
                  type="button"
                  @click="router.back()"
                  class="bg-slate-100 hover:bg-slate-200 text-slate-600 px-5 py-3 rounded-2xl font-bold text-xs transition cursor-pointer"
                >
                  Batal
                </button>
              </div>
            </form>
          </div>

          <!-- SUCCESS CARD & PASS TICKET VIEW -->
          <div v-else class="space-y-4">
            <!-- Alert Berhasil -->
            <div class="bg-emerald-50 border border-emerald-200/80 p-4 rounded-2xl flex items-center gap-3">
              <span class="w-8 h-8 rounded-xl bg-emerald-500 text-white font-bold flex items-center justify-center text-sm shadow-xs">✓</span>
              <div>
                <h4 class="text-xs font-black text-emerald-800">Pendaftaran Berhasil!</h4>
                <p class="text-[11px] text-emerald-600 font-medium">Data akun member berhasil disimpan ke dalam sistem.</p>
              </div>
            </div>

            <!-- Kartu Member Card -->
            <div id="print-area" class="bg-white rounded-3xl border border-slate-100 shadow-xs overflow-hidden p-6">
              <!-- Header Kartu -->
              <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-5">
                <div class="flex items-center gap-2.5">
                  <div class="w-8 h-8 rounded-xl bg-[#0B0F19] text-cyan-400 font-black flex items-center justify-center text-xs">
                    P
                  </div>
                  <div>
                    <h3 class="text-xs font-extrabold text-slate-900 leading-none">KARTU MEMBER PARKIR</h3>
                    <span class="text-[9px] text-slate-400 font-bold uppercase tracking-wider">PLAZA ANDALAS</span>
                  </div>
                </div>
                <span
                  class="px-2.5 py-1 rounded-full text-[10px] font-bold"
                  :class="isAktif ? 'bg-emerald-50 text-emerald-600 border border-emerald-200' : 'bg-rose-50 text-rose-600 border border-rose-200'"
                >
                  {{ isAktif ? 'Lunas (Aktif)' : 'Belum Lunas' }}
                </span>
              </div>

              <!-- Frame QR Code -->
              <div class="flex justify-center my-4">
                <div class="p-3 bg-slate-50 border border-slate-100 rounded-2xl flex items-center justify-center shadow-xs">
                  <img
                    :src="qrCodeUrl"
                    alt="QR Code Member"
                    class="w-44 h-44 object-contain"
                    @error="handleImageError"
                  />
                </div>
              </div>

              <!-- Metadata List -->
              <div class="bg-slate-50 border border-slate-100 rounded-2xl p-4 space-y-2 text-xs">
                <div class="flex justify-between items-center py-1 border-b border-slate-200/60">
                  <span class="text-slate-400 font-bold">Kode Member</span>
                  <span class="font-mono font-black text-indigo-600">{{ memberCode }}</span>
                </div>
                <div class="flex justify-between items-center py-1 border-b border-slate-200/60">
                  <span class="text-slate-400 font-bold">Nama</span>
                  <span class="font-extrabold text-slate-800">{{ suksesData.nama_member }}</span>
                </div>
                <div class="flex justify-between items-center py-1 border-b border-slate-200/60">
                  <span class="text-slate-400 font-bold">Perusahaan</span>
                  <span class="font-semibold text-slate-700">{{ suksesData.nama_perusahaan }}</span>
                </div>
                <div class="flex justify-between items-center py-1 border-b border-slate-200/60">
                  <span class="text-slate-400 font-bold">Tarif Terdaftar</span>
                  <span class="font-black text-slate-900">Rp {{ formatRupiah(suksesData.total_harga || 150000) }}</span>
                </div>
                <div class="flex justify-between items-center py-1 border-b border-slate-200/60">
                  <span class="text-slate-400 font-bold">Nominal Bayar</span>
                  <span class="font-bold text-slate-700">Rp {{ formatRupiah(suksesData.jumlah_bayar || form.uang_bayar) }}</span>
                </div>
                <div class="flex justify-between items-center py-1 border-b border-slate-200/60">
                  <span class="text-slate-400 font-bold">Status Pembayaran</span>
                  <span
                    :class="isAktif ? 'text-emerald-600' : 'text-rose-600'"
                    class="font-black uppercase"
                  >
                    {{ isAktif ? 'LUNAS' : 'BELUM LUNAS' }}
                  </span>
                </div>
                <div class="flex justify-between items-center py-1 border-b border-slate-200/60">
                  <span class="text-slate-400 font-bold">Tanggal Mulai</span>
                  <span class="font-medium text-slate-700">{{ formatDate(suksesData.tanggal_mulai || new Date()) }}</span>
                </div>
                <div class="flex justify-between items-center py-1">
                  <span class="text-slate-400 font-bold">Berlaku Sampai</span>
                  <span class="font-medium text-slate-700">{{ formatDate(suksesData.tanggal_expired) }}</span>
                </div>
              </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-3">
              <button
                @click="cetakKartu"
                class="flex-1 bg-[#0284C7] hover:bg-[#0369A1] text-white py-3 rounded-2xl font-black text-xs transition cursor-pointer shadow-xs"
              >
                Cetak / Download Kartu
              </button>
              <button
                @click="router.push('/petugas/member/select')"
                class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-700 py-3 rounded-2xl font-bold text-xs transition cursor-pointer"
              >
                Kembali ke Daftar
              </button>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useRouter } from 'vue-router'

definePageMeta({
  middleware: 'auth'
})

const { $api } = useNuxtApp()
const router = useRouter()

const form = ref({
  nama_member: '',
  nama_perusahaan: '',
  uang_bayar: 150000
})

const loading = ref(false)
const suksesData = ref(null)

const memberCode = computed(() => {
  const data = suksesData.value
  if (!data) return 'DEFAULT'
  return data.kode_member || data.kode || data.id_member || (data.id ? `MBR-${data.id}` : 'DEFAULT')
})

const qrCodeUrl = computed(() => {
  if (suksesData.value?.qr) return suksesData.value.qr
  return `http://localhost:8000/api/qrcode/${memberCode.value}`
})

const isAktif = computed(() => {
  const statusLunas = suksesData.value?.status === 'lunas'
  const belumExpired = suksesData.value?.tanggal_expired
    ? new Date(suksesData.value.tanggal_expired) >= new Date()
    : true

  return Boolean(statusLunas && belumExpired)
})

const formatDate = (dateString) => {
  if (!dateString) return '-'
  const d = new Date(dateString)
  return d.toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' })
}

const formatRupiah = (angka) => {
  return new Intl.NumberFormat('id-ID').format(Number(angka || 0))
}

const handleImageError = (e) => {
  if (suksesData.value?.id) {
    e.target.src = `http://localhost:8000/api/qrcode/${suksesData.value.id}`
  }
}

const submitForm = async () => {
  loading.value = true
  try {
    const res = await $api.post('/member', form.value)
    suksesData.value = res.data.data || res.data
  } catch (err) {
    alert(err.response?.data?.message || 'Gagal menambahkan member')
  } finally {
    loading.value = false
  }
}

const cetakKartu = () => window.print()

const logout = async () => {
  try {
    await $api.post('/logout')
  } catch {}
  localStorage.removeItem('token')
  router.push('/')
}
</script>

<style scoped>
@media print {
  aside, header, button, .alert-success {
    display: none !important;
  }
  main {
    height: auto !important;
    overflow: visible !important;
    background: white !important;
    padding: 0 !important;
  }
  #print-area {
    border: none !important;
    box-shadow: none !important;
    padding: 0 !important;
    width: 100% !important;
  }
}
</style>