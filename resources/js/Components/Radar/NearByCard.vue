<script setup>
import { computed } from 'vue'
import Equalizer from './Equalizer.vue'

const props = defineProps({
  playback: { type: Object, required: true },
  delay: { type: Number, default: 0 }
})

const distance = computed(() => Math.round(props.playback.distance_meters))

const formattedDistance = computed(() => distance.value + 'm')

const distanceBadgeClass = computed(() => {
  if (distance.value <= 25) return 'bg-emerald-500/10 text-emerald-400'
  if (distance.value <= 60) return 'bg-amber-500/10 text-amber-400'
  return 'bg-zinc-500/10 text-zinc-500'
})

const dotClass = computed(() => {
  if (distance.value <= 25) return 'bg-emerald-400'
  if (distance.value <= 60) return 'bg-amber-400'
  return 'bg-zinc-500'
})
</script>

<template>
    <article
      class="card-enter group flex items-center gap-3.5 rounded-2xl border border-white/[0.06] bg-white/[0.03] p-3 backdrop-blur-xl transition-all duration-300 active:scale-[0.98]"
      :style="{ animationDelay: delay + 'ms' }"
    >
      <!-- Album cover with equalizer overlay -->
      <div class="relative flex-shrink-0 overflow-hidden rounded-xl">
        <img
          :src="playback.album_image_url"
          :alt="`${playback.track_name} album cover`"
          class="h-[72px] w-[72px] object-cover"
          loading="lazy"
        />
        <!-- Gradient overlay -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent" />
        <!-- Equalizer -->
        <div class="absolute bottom-1.5 left-1.5">
          <Equalizer :size="14" color="#1DB954" />
        </div>
      </div>
  
      <!-- Track + User info -->
      <div class="flex min-w-0 flex-1 flex-col gap-1">
        <!-- Track name -->
        <h3 class="truncate text-[15px] font-semibold leading-tight text-white">
          {{ playback.track_name }}
        </h3>
        <!-- Artist -->
        <p class="truncate text-[13px] leading-tight text-zinc-400">
          {{ playback.artist_name }}
        </p>
        <!-- User row -->
        <div class="mt-0.5 flex items-center gap-1.5">
          <img
            :src="playback.user.avatar"
            :alt="playback.user.name"
            class="h-4 w-4 rounded-full ring-1 ring-white/10"
            loading="lazy"
          />
          <span class="text-[11px] font-medium text-zinc-500">
            {{ playback.user.name }}
          </span>
        </div>
      </div>
  
      <!-- Distance badge -->
      <div class="flex flex-shrink-0 flex-col items-end gap-1">
        <span
          class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-[11px] font-semibold tracking-wide"
          :class="distanceBadgeClass"
        >
          <span class="h-1.5 w-1.5 rounded-full" :class="dotClass" />
          {{ formattedDistance }}
        </span>
      </div>
    </article>
</template>

<style scoped>
  .card-enter {
    animation: slideUp 0.5s ease-out both;
  }
  
  @keyframes slideUp {
    from {
      opacity: 0;
      transform: translateY(20px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
</style>
  