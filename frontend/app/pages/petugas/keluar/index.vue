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

          <!-- Active Menu: Gate Keluar (Kasir) -->
          <NuxtLink
            to="/petugas/keluar"
            class="flex items-center justify-between px-3.5 py-2.5 rounded-xl bg-slate-800/90 text-white font-semibold text-xs shadow-xs"
          >
            <div class="flex items-center gap-3">
              <span class="text-sm text-cyan-400">🚪</span>
              <span>Gate Keluar (Kasir)</span>
            </div>
            <span class="text-xs text-cyan-400 font-bold">●</span>
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
            class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/40 text-xs font-semibold transition"
          >
            <div class="flex items-center gap-3">
              <span class="text-sm">👥</span>
              <span>Kelola Member</span>
            </div>
            <span class="text-xs text-slate-600">›</span>
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

      <!-- Bottom Profile Card & Logout -->
      <div class="space-y-3 pt-4 border-t border-slate-800/80">
        <div class="bg-slate-900/90 border border-slate-800 px-3.5 py-2.5 rounded-2xl flex items-center gap-3">
          <div class="w-8 h-8 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 flex items-center justify-center text-xs font-bold">
            P
          </div>
          <div class="min-w-0 flex-1">
            <p class="text-xs font-bold text-white truncate">Petugas Parkir</p>
            <p class="text-[10px] text-emerald-400 font-medium">Pos Kasir Aktif</p>
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

    <!-- KONTEN UTAMA POS KASIR KELUAR -->
    <main class="flex-1 flex flex-col min-w-0 h-screen overflow-y-auto">
      <!-- HEADER DASHBOARD STYLE -->
      <header class="bg-white px-8 py-5 flex items-center justify-between border-b border-slate-100 shrink-0">
        <div>
          <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">PLAZA ANDALAS SYSTEM</span>
          <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">Gate Keluar - Kasir Pembayaran</h1>
        </div>

        <div class="flex items-center gap-3">
          <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-200/60">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            Pos Kasir Online
          </span>
          <NuxtLink
            to="/petugas"
            class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2 rounded-full text-xs font-bold transition flex items-center gap-1.5 cursor-pointer shadow-xs"
          >
            <span>←</span> Dashboard
          </NuxtLink>
        </div>
      </header>

      <!-- BODY SCAN & CASHIER WRAPPER -->
      <div class="p-8 flex justify-center items-start">
        <div class="w-full max-w-lg space-y-5">
          <!-- CARD KASIR / SCANNER -->
          <div class="bg-white rounded-3xl border border-slate-100 shadow-xs p-7 space-y-5">
            <div>
              <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">CHECK-OUT TERMINAL</span>
              <h2 class="text-lg font-black text-slate-900 tracking-tight mt-0.5">Validasi Tiket & Kartu Member</h2>
              <p class="text-xs text-slate-400 mt-1">Scan barcode tiket fisik atau tempel kode kartu member untuk membuka gate keluar.</p>
            </div>

            <!-- FITUR SCANNER KAMERA -->
            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200/80 text-center">
              <button
                @click="toggleScanner"
                type="button"
                class="w-full bg-[#0284C7] hover:bg-[#0369A1] text-white py-2.5 rounded-xl font-black text-xs shadow-xs transition flex items-center justify-center gap-2 cursor-pointer"
              >
                <span>📷</span> {{ scannerActive ? 'Tutup Kamera Scanner' : 'Aktifkan Kamera Scanner' }}
              </button>
              <div v-show="scannerActive" id="reader" class="mt-3 overflow-hidden rounded-2xl border border-slate-200 bg-white"></div>
            </div>

            <!-- INPUT SCAN KODE MANUAL / BARCODE GUN -->
            <div>
              <label class="block text-xs font-bold text-slate-700 mb-1.5">Scan Barcode / Kode Tiket / Member</label>
              <div class="flex gap-2">
                <input
                  v-model="form.kode"
                  type="text"
                  @keyup.enter="prosesScan"
                  placeholder="Contoh: A123 atau MBR-xxxx"
                  autofocus
                  class="w-full bg-slate-50 border border-slate-200 focus:border-[#0284C7] focus:bg-white focus:ring-2 focus:ring-[#0284C7]/20 rounded-2xl px-4 py-3 text-xs font-black uppercase text-slate-800 outline-none transition"
                />
                <button
                  @click="prosesScan"
                  :disabled="loading"
                  type="button"
                  class="bg-[#0B0F19] hover:bg-slate-800 text-white px-5 rounded-2xl font-black text-xs transition cursor-pointer disabled:opacity-50"
                >
                  {{ loading ? '...' : 'Cari' }}
                </button>
              </div>
            </div>

            <!-- DETAIL TRANSAKSI SETELAH SCAN -->
            <div v-if="detailTransaksi" class="space-y-4 border-t border-slate-100 pt-5">
              <!-- Ringkasan Akses -->
              <div class="bg-slate-50 border border-slate-100 rounded-2xl p-4 space-y-2 text-xs">
                <div class="flex justify-between items-center py-1 border-b border-slate-200/60">
                  <span class="text-slate-400 font-bold">Tipe Akses</span>
                  <span class="font-mono font-black uppercase" :class="tipeAkses === 'member' ? 'text-cyan-600' : 'text-indigo-600'">
                    {{ tipeAkses }}
                  </span>
                </div>
                <div class="flex justify-between items-center py-1 border-b border-slate-200/60">
                  <span class="text-slate-400 font-bold">Kode / Identitas</span>
                  <span class="font-mono font-black text-slate-800">{{ detailTransaksi.kode_tiket || detailTransaksi.kode_member }}</span>
                </div>
                <div v-if="tipeAkses === 'tiket'" class="flex justify-between items-center py-1 border-b border-slate-200/60">
                  <span class="text-slate-400 font-bold">Waktu Masuk</span>
                  <span class="font-medium text-slate-700">{{ formatWaktu(detailTransaksi.waktu_masuk) }}</span>
                </div>
                <div v-if="tipeAkses === 'tiket'" class="flex justify-between items-center py-1">
                  <span class="text-slate-400 font-bold">Durasi Terhitung</span>
                  <span class="font-black text-indigo-600">{{ durasiJam }} Jam</span>
                </div>
              </div>

              <!-- JIKA TIPE TIKET UMUM (NON-MEMBER) -->
              <template v-if="tipeAkses === 'tiket'">
                <!-- Kategori Kendaraan Otomatis Terdeteksi dari Gate Masuk (Bukan Dropdown Manual) -->
                <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-4 flex items-center justify-between">
                  <div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Kategori Kendaraan Terdeteksi</span>
                    <div class="flex items-center gap-2 mt-0.5">
                      <span class="text-xl">{{ form.kategori === 'mobil' ? '🚗' : '🛵' }}</span>
                      <span class="text-sm font-black text-slate-900 uppercase tracking-wide">{{ form.kategori }}</span>
                    </div>
                  </div>
                  <div class="text-right">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Tarif / Jam</span>
                    <span class="text-xs font-black text-indigo-600 font-mono">
                      Rp {{ formatRupiah(form.kategori === 'mobil' ? 5000 : 2000) }}
                    </span>
                  </div>
                </div>

                <!-- Input No Plat -->
                <div>
                  <label class="block text-xs font-bold text-slate-700 mb-1.5">No. Plat Kendaraan</label>
                  <input
                    v-model="form.nopol"
                    type="text"
                    placeholder="Contoh: B 1234 ABC"
                    class="w-full bg-slate-50 border border-slate-200 focus:border-[#0284C7] focus:bg-white focus:ring-2 focus:ring-[#0284C7]/20 rounded-2xl px-4 py-3 text-xs font-black uppercase text-slate-800 outline-none transition"
                  />
                </div>

                <!-- Input Uang Bayar Tunai & Tombol Cepat Pecahan Dinamis -->
                <div>
                  <label class="block text-xs font-bold text-slate-700 mb-1.5">Uang Tunai Diterima (Rp)</label>
                  <div class="relative mb-2.5">
                    <span class="absolute left-4 top-3 text-xs font-bold text-slate-400">Rp</span>
                    <input
                      v-model.number="form.uang_bayar"
                      type="number"
                      min="0"
                      placeholder="0"
                      class="w-full bg-slate-50 border border-slate-200 focus:border-[#0284C7] focus:bg-white focus:ring-2 focus:ring-[#0284C7]/20 rounded-2xl pl-11 pr-4 py-3 text-xs font-black text-slate-800 outline-none transition"
                    />
                  </div>

                  <div class="flex flex-wrap gap-1.5">
                    <!-- Tombol Uang Pas -->
                    <button
                      @click="setNominal(totalTarif)"
                      type="button"
                      class="text-[11px] font-bold px-3 py-1.5 rounded-xl border transition cursor-pointer"
                      :class="Number(form.uang_bayar) === totalTarif ? 'bg-[#0284C7] text-white border-[#0284C7] shadow-xs' : 'bg-slate-100 text-slate-700 border-slate-200 hover:bg-slate-200'"
                    >
                      Uang Pas (Rp {{ formatRupiah(totalTarif) }})
                    </button>
                    <!-- Pecahan Uang Cepat -->
                    <button
                      v-for="nominal in opsiPecahan"
                      :key="nominal"
                      @click="setNominal(nominal)"
                      type="button"
                      class="text-[11px] font-bold px-3 py-1.5 rounded-xl border transition cursor-pointer"
                      :class="Number(form.uang_bayar) === nominal ? 'bg-[#0B0F19] text-white border-[#0B0F19] shadow-xs' : 'bg-slate-100 text-slate-700 border-slate-200 hover:bg-slate-200'"
                    >
                      Rp {{ formatRupiah(nominal) }}
                    </button>
                  </div>
                </div>

                <!-- KOTAK KALKULASI TOTAL KASIR -->
                <div class="bg-[#0B0F19] text-white p-5 rounded-2xl space-y-3 shadow-inner">
                  <div class="flex justify-between items-center">
                    <span class="text-xs font-bold text-slate-400">TOTAL TARIF ({{ durasiJam }} JAM × Rp {{ formatRupiah(form.kategori === 'mobil' ? 5000 : 2000) }})</span>
                    <span class="text-xl font-black text-emerald-400">Rp {{ formatRupiah(totalTarif) }}</span>
                  </div>
                  <hr class="border-slate-800" />
                  <div class="flex justify-between items-center">
                    <span class="text-xs font-bold text-slate-400">KEMBALIAN</span>
                    <span class="text-base font-black text-emerald-400">
                      Rp {{ formatRupiah(hitungKembalian) }}
                    </span>
                  </div>
                </div>

                <!-- Tombol Bayar -->
                <button
                  @click="konfirmasiBayar"
                  :disabled="loading"
                  type="button"
                  class="w-full bg-emerald-600 hover:bg-emerald-700 disabled:bg-slate-300 text-white font-black p-3.5 rounded-2xl shadow-xs transition cursor-pointer uppercase tracking-wider text-xs"
                >
                  {{ loading ? 'Memproses Transaksi...' : 'BAYAR & BUKA GATE KELUAR' }}
                </button>
              </template>

              <!-- JIKA TIPE MEMBER VALID -->
              <div v-else class="p-5 bg-emerald-50 border border-emerald-200/80 text-emerald-700 rounded-2xl text-center font-bold text-xs">
                <span class="text-base block mb-1">✓</span>
                Akses Member Valid! Palang pintu gate keluar otomatis dibuka.
              </div>
            </div>

            <!-- Tombol Batal / Reset Form -->
            <button
              @click="batal"
              type="button"
              class="w-full bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold p-3 rounded-2xl transition cursor-pointer text-xs"
            >
              BATAL / RESET TRANSAKSI
            </button>
          </div>
        </div>
      </div>
    </main>

    <!-- MODAL POPUP -->
    <div v-if="modal.show" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4 z-50">
      <div class="bg-white rounded-3xl max-w-sm w-full p-6 text-center shadow-2xl border border-slate-100">
        <h3 class="text-base font-black text-slate-900 mb-2">{{ modal.title }}</h3>
        <p class="text-xs text-slate-600 mb-6 leading-relaxed whitespace-pre-line">{{ modal.message }}</p>
        <button
          @click="closeModal"
          class="w-full py-3 rounded-2xl font-black text-xs text-white bg-[#0B0F19] hover:bg-slate-800 transition cursor-pointer shadow-xs"
        >
          Tutup / Mengerti
        </button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, reactive, computed, onUnmounted } from 'vue'
import { Html5QrcodeScanner } from 'html5-qrcode'

definePageMeta({ middleware: 'auth' })

const { $api } = useNuxtApp()
const router = useRouter()
const loading = ref(false)
const detailTransaksi = ref<any>(null)
const tipeAkses = ref('')
const durasiJam = ref<number>(1)
const scannerActive = ref(false)
let html5QrcodeScanner: Html5QrcodeScanner | null = null

const modal = reactive({ show: false, title: '', message: '', onClose: null as any })
const triggerModal = (title: string, message: string, onCloseCallback: any = null) => {
  modal.title = title
  modal.message = message
  modal.onClose = onCloseCallback
  modal.show = true
}
const closeModal = () => {
  modal.show = false
  if (modal.onClose) modal.onClose()
}

const form = reactive({ kode: '', kategori: 'motor', nopol: '', uang_bayar: 2000 })

const toggleScanner = () => {
  scannerActive.value = !scannerActive.value
  if (scannerActive.value) {
    setTimeout(() => {
      html5QrcodeScanner = new Html5QrcodeScanner('reader', { fps: 10, qrbox: { width: 250, height: 150 } }, false)
      html5QrcodeScanner.render((text) => {
        form.kode = text.trim()
        stopScanner()
        prosesScan()
      }, () => {})
    }, 100)
  } else {
    stopScanner()
  }
}

const stopScanner = () => {
  if (html5QrcodeScanner) {
    html5QrcodeScanner.clear().catch(() => {})
    html5QrcodeScanner = null
  }
  scannerActive.value = false
}
onUnmounted(() => stopScanner())

// Pecahan Dinamis mengikuti Kategori
const opsiPecahan = computed(() =>
  form.kategori === 'mobil' ? [5000, 10000, 20000, 50000, 100000] : [2000, 5000, 10000, 20000, 50000]
)

const setNominal = (val: number) => {
  form.uang_bayar = Number(val)
}

const totalTarif = computed(() => {
  const tarifPerJam = form.kategori === 'mobil' ? 5000 : 2000
  return tarifPerJam * Number(durasiJam.value || 1)
})

const hitungKembalian = computed(() => Math.max(0, Number(form.uang_bayar || 0) - totalTarif.value))

const prosesScan = async () => {
  if (!form.kode) {
    triggerModal('Peringatan', 'Masukkan kode tiket atau member!')
    return
  }
  loading.value = true
  try {
    const res = await $api.post('/gate/scan', { kode: form.kode })
    tipeAkses.value = res.data.type
    detailTransaksi.value = res.data.data
    durasiJam.value = Number(res.data.data.durasi_jam) || 1

    if (res.data.type === 'tiket') {
      // 1. OTOMATIS AMBIL KATEGORI HASIL SCAN DARI TIKET GATE MASUK
      form.kategori = (res.data.data.kategori || 'motor').toLowerCase()

      // 2. OTOMATIS SET UANG BAYAR DEFAULT MENGIKUTI TOTAL TARIF
      const calculatedTarif = (form.kategori === 'mobil' ? 5000 : 2000) * durasiJam.value
      form.uang_bayar = Number(res.data.data.total_tarif) || calculatedTarif
    } else if (res.data.type === 'member') {
      triggerModal('Akses Member Valid', `${res.data.message}\nPalang pintu gerbang keluar terbuka otomatis.`, () => batal())
    }
  } catch (err: any) {
    triggerModal('Gagal', err?.response?.data?.message || 'Data tidak ditemukan!')
    detailTransaksi.value = null
  } finally {
    loading.value = false
  }
}

const konfirmasiBayar = async () => {
  if (!detailTransaksi.value) return
  if (Number(form.uang_bayar) < totalTarif.value) {
    triggerModal('Pembayaran Kurang', 'Uang tunai kurang dari total tarif!')
    return
  }

  loading.value = true
  try {
    await $api.post('/transaksi/bayar', {
      tiket_id: detailTransaksi.value.id,
      nopol: form.nopol,
      kategori: form.kategori,
      total_bayar: totalTarif.value,
      bayar: Number(form.uang_bayar)
    })
    triggerModal('Berhasil!', 'Pembayaran lunas! Gate keluar terbuka otomatis.', () => batal())
  } catch (err: any) {
    triggerModal('Gagal', err?.response?.data?.message || 'Terjadi kesalahan sistem.')
  } finally {
    loading.value = false
  }
}

const batal = () => {
  detailTransaksi.value = null
  tipeAkses.value = ''
  form.kode = ''
  form.nopol = ''
  form.kategori = 'motor'
  form.uang_bayar = 2000
  durasiJam.value = 1
}

const formatWaktu = (d: any) => (d ? new Date(d).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }) + ' WIB' : '-')
const formatRupiah = (v: any) => new Intl.NumberFormat('id-ID').format(Number(v || 0))

const logout = async () => {
  try {
    await $api.post('/logout')
  } catch {}
  localStorage.removeItem('token')
  router.push('/')
}
</script>