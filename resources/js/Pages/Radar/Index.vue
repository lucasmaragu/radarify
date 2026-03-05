<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { Head } from '@inertiajs/vue3'
import axios from 'axios'
import { WifiOff } from 'lucide-vue-next'
import RadarPulse from '@/Components/Radar/RadarPulse.vue'
import Equalizer from '@/Components/Radar/Equalizer.vue'
import BottomTabBar from '@/Components/Radar/BottomTabBar.vue'
import NearByCard from '@/Components/Radar/NearByCard.vue'

const nearbyUsers = ref([])
const isLoading = ref(true)
const activeTab = ref('radar')
let radarInterval = null

const scanRadar = async () => {
  try {
    const response = await axios.get('/radar/sync')
    nearbyUsers.value = response.data.playbacks
  } catch (error) {
    console.error('Error al escanear el radar:', error)
  } finally {
    isLoading.value = false
  }
}

onMounted(() => {
  scanRadar()
  radarInterval = setInterval(scanRadar, 10000)
})

onUnmounted(() => {
  clearInterval(radarInterval)
})
</script>

<template>
  <Head title="Radar de Proximidad" />

  <div class="relative min-h-dvh bg-zinc-950 font-sans text-white">

    <header
      class="sticky top-0 z-40 border-b border-white/[0.04] bg-zinc-950/70 backdrop-blur-2xl"
      :style="{ paddingTop: 'env(safe-area-inset-top, 0px)' }"
    >
      <div class="flex items-center justify-between px-5 py-3">
        <!-- Left: Logo area -->
        <div class="flex items-center gap-2.5">
          <div class="flex h-8 w-8 items-center justify-center rounded-full bg-[#1DB954]/10">
            <Equalizer :size="16" color="#1DB954" />
          </div>
          <div>
            <h1 class="text-[15px] font-bold leading-none tracking-tight text-white">
              Radarify
            </h1>
            <p class="mt-0.5 text-[11px] font-medium text-zinc-500">
              <span v-if="isLoading">Escaneando...</span>
              <span v-else-if="nearbyUsers.length > 0">
                {{ nearbyUsers.length }}
                {{ nearbyUsers.length === 1 ? 'persona' : 'personas' }} cerca
              </span>
              <span v-else>Sin actividad</span>
            </p>
          </div>
        </div>

        <!-- Right: Status badges -->
        <div class="flex items-center gap-2">
          <!-- Live indicator -->
          <span class="flex items-center gap-1.5 rounded-full bg-[#1DB954]/10 px-2.5 py-1">
            <span class="relative flex h-1.5 w-1.5">
              <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-[#1DB954] opacity-75" />
              <span class="relative inline-flex h-1.5 w-1.5 rounded-full bg-[#1DB954]" />
            </span>
            <span class="text-[10px] font-semibold uppercase tracking-wider text-[#1DB954]">Live</span>
          </span>
          <!-- Range badge -->
          <span class="rounded-full bg-white/[0.06] px-2.5 py-1 text-[10px] font-semibold uppercase tracking-wider text-zinc-400">
            100m
          </span>
        </div>
      </div>
    </header>

    <main class="px-4 pb-28 pt-4">

      <!--
        STATE 1: Loading — Radar pulse animation
      -->
      <div
        v-if="isLoading"
        class="flex flex-col items-center justify-center gap-6 pt-24"
      >
        <RadarPulse :size="160" color="#1DB954" />
        <div class="mt-4 text-center">
          <p class="text-sm font-medium text-zinc-400">Escaneando la zona...</p>
          <p class="mt-1 text-xs text-zinc-600">Detectando actividad musical cercana</p>
        </div>
      </div>

      <!--
        STATE 2: Empty — No nearby users
      -->
      <div
        v-else-if="nearbyUsers.length === 0"
        class="flex flex-col items-center justify-center gap-5 pt-24"
      >
        <div class="flex h-20 w-20 items-center justify-center rounded-full bg-white/[0.03] ring-1 ring-white/[0.06]">
          <WifiOff :size="32" class="text-zinc-600" />
        </div>
        <div class="text-center">
          <p class="text-sm font-medium text-zinc-300">Todo en silencio</p>
          <p class="mt-1 max-w-[240px] text-xs leading-relaxed text-zinc-600">
            No hay nadie escuchando musica cerca de ti en este momento.
          </p>
        </div>
        <button
          class="mt-2 rounded-full bg-white/[0.06] px-5 py-2 text-xs font-semibold text-zinc-300 transition-colors active:bg-white/[0.1]"
          @click="isLoading = true; scanRadar()"
        >
          Escanear de nuevo
        </button>
      </div>

      <!--
        STATE 3: Results — Nearby user cards
      -->
      <template v-else>
        <!-- Section label -->
        <div class="mb-3 flex items-center justify-between px-1">
          <h2 class="text-xs font-semibold uppercase tracking-widest text-zinc-500">
            Cerca de ti
          </h2>
          <span class="text-[10px] tabular-nums text-zinc-600">
            actualizado hace unos segundos
          </span>
        </div>
        <!-- Cards list -->
        <div class="flex flex-col gap-3">
          <NearByCard
            v-for="(playback, index) in nearbyUsers"
            :key="playback.id"
            :playback="playback"
            :delay="index * 100"
          />
        </div>
      </template>
    </main>

    <BottomTabBar :active-tab="activeTab" @change-tab="activeTab = $event" />
  </div>
</template>

