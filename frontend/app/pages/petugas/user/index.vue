<template>
  <div class="min-h-screen bg-[#F8FAFC] flex font-sans antialiased text-slate-800">
    <!-- SIDEBAR PERSIS REFERENSI -->
    <aside class="w-64 bg-[#0B0F19] text-slate-400 flex flex-col justify-between py-6 px-4 shrink-0 select-none hidden md:flex">
      <div>
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

        <nav class="space-y-1">
          <NuxtLink to="/petugas" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/40 font-semibold text-xs transition">
            <span class="text-sm">⊞</span>
            <span>Dashboard</span>
          </NuxtLink>
          <NuxtLink to="/petugas/user" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl bg-slate-800/90 text-white font-semibold text-xs shadow-xs">
            <div class="flex items-center gap-3">
              <span class="text-sm text-cyan-400">🟢</span>
              <span>Gate Masuk</span>
            </div>
            <span class="text-xs text-cyan-400 font-bold">●</span>
          </NuxtLink>
          <NuxtLink to="/petugas/keluar" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/40 text-xs font-semibold transition">
            <div class="flex items-center gap-3">
              <span class="text-sm">🚪</span>
              <span>Gate Keluar (Kasir)</span>
            </div>
            <span class="text-xs text-slate-600">›</span>
          </NuxtLink>
          <NuxtLink to="/petugas/transaksi" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/40 text-xs font-semibold transition">
            <div class="flex items-center gap-3">
              <span class="text-sm">🚗</span>
              <span>Kelola Transaksi</span>
            </div>
            <span class="text-xs text-slate-600">›</span>
          </NuxtLink>
          <NuxtLink to="/petugas/member/select" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/40 text-xs font-semibold transition">
            <div class="flex items-center gap-3">
              <span class="text-sm">👥</span>
              <span>Kelola Member</span>
            </div>
            <span class="text-xs text-slate-600">›</span>
          </NuxtLink>
          <NuxtLink to="/petugas/laporan/member" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/40 text-xs font-semibold transition">
            <div class="flex items-center gap-3">
              <span class="text-sm">📊</span>
              <span>Laporan</span>
            </div>
            <span class="text-xs text-slate-600">›</span>
          </NuxtLink>
          <NuxtLink to="/petugas/markir" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/40 text-xs font-semibold transition">
            <div class="flex items-center gap-3">
              <span class="text-sm">🅿️</span>
              <span>Sedang Parkir</span>
            </div>
            <span class="text-xs text-slate-600">›</span>
          </NuxtLink>
        </nav>
      </div>

      <div class="space-y-3 pt-4 border-t border-slate-800/80">
        <div class="bg-slate-900/90 border border-slate-800 px-3.5 py-2.5 rounded-2xl flex items-center gap-3">
          <div class="w-8 h-8 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 flex items-center justify-center text-xs font-bold">
            P
          </div>
          <div class="min-w-0 flex-1">
            <p class="text-xs font-bold text-white truncate">Petugas Parkir</p>
            <p class="text-[10px] text-emerald-400 font-medium">Gate Masuk Online</p>
          </div>
        </div>

        <button @click="logout" class="w-full flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold text-rose-400 hover:bg-rose-500/10 transition cursor-pointer">
          <span>🚪</span>
          <span>Logout</span>
        </button>
      </div>
    </aside>

    <!-- CONTENT UTAMA -->
    <main class="flex-1 flex flex-col min-w-0 h-screen overflow-y-auto">
      <header class="bg-white px-8 py-5 flex items-center justify-between border-b border-slate-100 shrink-0">
        <div>
          <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">PLAZA ANDALAS SYSTEM</span>
          <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">Kiosk Gate Masuk</h1>
        </div>

        <div class="flex items-center gap-3">
          <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-200/60">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            Sensor Palang Aktif
          </span>
          <NuxtLink to="/petugas" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2 rounded-full text-xs font-bold transition flex items-center gap-1.5 shadow-xs">
            <span>←</span> Dashboard
          </NuxtLink>
        </div>
      </header>

      <div class="p-8 flex justify-center items-start">
        <div class="w-full max-w-md space-y-6">
          <!-- CARD KIOSK UTAMA -->
          <div class="bg-white rounded-3xl border border-slate-100 shadow-xs p-7 space-y-6">
            <!-- SECTION 1: CETAK TIKET NON MEMBER -->
            <div class="text-center space-y-2">
              <div class="w-12 h-12 mx-auto rounded-2xl bg-[#0B0F19] text-cyan-400 flex items-center justify-center text-xl font-black shadow-md">
                P
              </div>
              <h2 class="text-lg font-black text-slate-900 tracking-tight">TIKET NON-MEMBER</h2>
              <p class="text-xs text-slate-400 font-medium leading-relaxed">
                Pilih kategori kendaraan untuk menerbitkan tiket barcode dan mengunduh PDF secara otomatis.
              </p>
            </div>

            <!-- TOMBOL PILIHAN KATEGORI / PRINT -->
            <div class="grid grid-cols-2 gap-3">
              <button
                @click="printTicket('motor')"
                :disabled="loading"
                class="p-4 rounded-2xl border border-slate-200 bg-slate-50 hover:bg-cyan-50 hover:border-cyan-400 hover:text-cyan-700 font-bold text-xs flex flex-col items-center gap-1 transition cursor-pointer disabled:opacity-50 group"
              >
                <span class="text-2xl group-hover:scale-110 transition">🛵</span>
                <span class="text-slate-800 font-extrabold group-hover:text-cyan-700">Motor</span>
                <span class="text-[10px] text-slate-400">Rp 2.000 / jam</span>
              </button>

              <button
                @click="printTicket('mobil')"
                :disabled="loading"
                class="p-4 rounded-2xl border border-slate-200 bg-slate-50 hover:bg-cyan-50 hover:border-cyan-400 hover:text-cyan-700 font-bold text-xs flex flex-col items-center gap-1 transition cursor-pointer disabled:opacity-50 group"
              >
                <span class="text-2xl group-hover:scale-110 transition">🚗</span>
                <span class="text-slate-800 font-extrabold group-hover:text-cyan-700">Mobil</span>
                <span class="text-[10px] text-slate-400">Rp 5.000 / jam</span>
              </button>
            </div>

            <div class="relative flex items-center justify-center my-2">
              <div class="border-t border-slate-200 w-full"></div>
              <span class="bg-white px-3 text-[10px] font-black uppercase text-slate-400 tracking-wider absolute">ATAU</span>
            </div>

            <!-- SECTION 2: SCAN MEMBER MASUK -->
            <div class="space-y-3 text-center">
              <div>
                <h3 class="text-sm font-black text-slate-900">TAP KARTU MEMBER</h3>
                <p class="text-xs text-slate-400 mt-0.5">Tempel barcode kartu member untuk membuka pintu otomatis</p>
              </div>

              <div class="flex gap-2">
                <input
                  v-model="cardInput"
                  autofocus
                  type="text"
                  placeholder="Scan Kode Member"
                  @keyup.enter="openGateMember"
                  class="w-full bg-slate-50 border border-slate-200 focus:border-[#0284C7] focus:bg-white focus:ring-2 focus:ring-[#0284C7]/20 rounded-2xl px-4 py-3 text-sm font-black text-center uppercase tracking-wider text-slate-800 outline-none transition"
                />
                <button
                  @click="openGateMember"
                  :disabled="loading"
                  type="button"
                  class="bg-[#0284C7] hover:bg-[#0369A1] text-white px-5 rounded-2xl font-black text-xs transition cursor-pointer disabled:opacity-50"
                >
                  Buka
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>

    <!-- MODAL POPUP PERSIS REFERENSI -->
    <div v-if="modal.show" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4 z-50">
      <div class="bg-white rounded-3xl max-w-sm w-full p-6 text-center shadow-2xl border border-slate-100">
        <h3 class="text-base font-black text-slate-900 mb-2">{{ modal.title }}</h3>
        <p class="text-xs text-slate-600 mb-6 leading-relaxed whitespace-pre-line">{{ modal.message }}</p>
        <button
          @click="modal.show = false"
          class="w-full py-3 rounded-2xl font-black text-xs text-white bg-[#0B0F19] hover:bg-slate-800 transition cursor-pointer shadow-xs"
        >
          Tutup / Mengerti
        </button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, reactive } from 'vue'
import { jsPDF } from 'jspdf'

definePageMeta({
  middleware: 'auth'
})

const { $api } = useNuxtApp()
const router = useRouter()

const loading = ref(false)
const cardInput = ref('')
const modal = reactive({ show: false, title: '', message: '' })

const triggerModal = (title: string, message: string) => {
  modal.title = title
  modal.message = message
  modal.show = true
}

// 1. FUNGSI PRINT & PDF GENERATOR TIKET NON-MEMBER
const printTicket = async (kategori: string = 'motor') => {
  loading.value = true
  try {
    const res = await $api.post('/tiket', { kategori })
    if (res.data && res.data.data) {
      const tiket = res.data.data

      // jsPDF format ukuran struk thermal kecil (80x110 mm)
      const doc = new jsPDF({
        orientation: 'portrait',
        unit: 'mm',
        format: [80, 110]
      })

      doc.setFont('Helvetica', 'bold')
      doc.setFontSize(13)
      doc.text('PLAZA ANDALAS', 40, 12, { align: 'center' })

      doc.setFontSize(8)
      doc.setFont('Helvetica', 'normal')
      doc.text(`TIKET MASUK (${kategori.toUpperCase()})`, 40, 18, { align: 'center' })

      doc.setLineDash([1, 1], 0)
      doc.line(10, 22, 70, 22)

      // Render QR code base64 ke Canvas lalu ke PDF
      try {
        if (tiket.qr_code) {
          const canvas = document.createElement('canvas')
          canvas.width = 200
          canvas.height = 200
          const ctx = canvas.getContext('2d')
          const img = new Image()
          img.src = tiket.qr_code

          await new Promise((resolve, reject) => {
            img.onload = () => {
              ctx?.drawImage(img, 0, 0, 200, 200)
              const pngData = canvas.toDataURL('image/png')
              doc.addImage(pngData, 'PNG', 25, 25, 30, 30)
              resolve(true)
            }
            img.onerror = reject
          })
        }
      } catch (e) {
        console.warn('Gagal merender QR Code ke PDF, lanjut cetak teks.', e)
      }

      // Kode Tiket
      doc.setFont('Helvetica', 'bold')
      doc.setFontSize(14)
      doc.text(tiket.kode_tiket.toUpperCase(), 40, 62, { align: 'center' })

      doc.line(10, 67, 70, 67)

      // Waktu Masuk
      doc.setFontSize(8)
      doc.setFont('Helvetica', 'normal')
      const waktuMasuk = tiket.waktu_masuk ? new Date(tiket.waktu_masuk).toLocaleString('id-ID') : new Date().toLocaleString('id-ID')
      doc.text(`Masuk: ${waktuMasuk}`, 40, 75, { align: 'center' })

      doc.line(10, 81, 70, 81)

      // Footer Catatan
      doc.setFontSize(8)
      doc.setFont('Helvetica', 'bold')
      doc.text('SIMPAN TIKET INI UNTUK KELUAR', 40, 92, { align: 'center' })
      doc.setFont('Helvetica', 'normal')
      doc.setFontSize(7)
      doc.text('PARKIR PLAZA ANDALAS AMAN & NYAMAN', 40, 97, { align: 'center' })

      // Download file PDF otomatis
      doc.save(`Tiket-Parkir-${tiket.kode_tiket}.pdf`)

      triggerModal('Tiket Diterbitkan!', `Kode: ${tiket.kode_tiket}\nKategori: ${kategori.toUpperCase()}\nFile PDF berhasil diunduh. Palang terbuka!`)
    }
  } catch (err: any) {
    triggerModal('Gagal', err?.response?.data?.message || 'Gagal menerbitkan tiket parkir!')
  } finally {
    loading.value = false
  }
}

// 2. FUNGSI TAP MEMBER MASUK (LANGSUNG TERSINKRON DENGAN GATE KELUAR)
const openGateMember = async () => {
  if (!cardInput.value) {
    triggerModal('Peringatan', 'Ketik atau scan barcode member terlebih dahulu!')
    return
  }

  loading.value = true
  try {
    const res = await $api.post('/gate/masuk-member', {
      kode: cardInput.value.trim()
    })

    if (res.data && res.data.status) {
      triggerModal('Akses Member Valid', `${res.data.message}\nPalang pintu gerbang masuk telah dibuka.`)
    }
  } catch (err: any) {
    triggerModal('Akses Ditolak', err?.response?.data?.message || 'Member tidak terdaftar atau belum tercatat lunas!')
  } finally {
    cardInput.value = ''
    loading.value = false
  }
}

const logout = async () => {
  try {
    await $api.post('/logout')
  } catch {}
  localStorage.removeItem('token')
  router.push('/')
}
</script>