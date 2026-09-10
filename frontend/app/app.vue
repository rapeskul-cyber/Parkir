<template>
  <div>
    <NuxtPage />
  </div>
</template>

<script setup>
import { onMounted, onUnmounted } from 'vue'

const checkThemeByTime = () => {
  const currentHour = new Date().getHours()
  // Siang (06:00 - 17:59) -> Mode Terang
  // Malam (18:00 - 05:59) -> Otomatis Mode Gelap
  const isNight = currentHour < 6 || currentHour >= 18

  if (isNight) {
    document.documentElement.classList.add('auto-dark-mode')
  } else {
    document.documentElement.classList.remove('auto-dark-mode')
  }
}

let timer = null

onMounted(() => {
  checkThemeByTime()
  // Cek setiap 1 menit, begitu jam 18:00 langsung otomatis ganti tanpa reload
  timer = setInterval(checkThemeByTime, 60000)
})

onUnmounted(() => {
  if (timer) clearInterval(timer)
})
</script>

<style>
/* CSS AJAIB OTOMATIS: Semua background putih/terang langsung jadi dark mode */
html.auto-dark-mode {
  filter: invert(0.92) hue-rotate(180deg);
  background-color: #121212 !important;
}

/* Kembalikan gambar, icon kamera, QR Code, dan video agar warnanya tidak ikut terbalik */
html.auto-dark-mode img,
html.auto-dark-mode video,
html.auto-dark-mode canvas,
html.auto-dark-mode #reader,
html.auto-dark-mode aside {
  filter: invert(1) hue-rotate(180deg);
}

/* Transisi halus saat pergantian mode */
html {
  transition: filter 0.4s ease-in-out;
}
</style>