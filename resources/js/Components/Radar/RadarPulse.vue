<script setup>
import { computed } from 'vue'

const props = defineProps({
  size: { type: Number, default: 160 },
  color: { type: String, default: '#1DB954' }
})

const ringStyle = computed(() => ({
  borderColor: props.color + '33'
}))
</script>

<template>
    <div class="relative flex items-center justify-center" :style="{ width: size + 'px', height: size + 'px' }">
      <!-- Pulse rings -->
      <span class="absolute inset-0 rounded-full border radar-ring-1" :style="ringStyle" />
      <span class="absolute inset-0 rounded-full border radar-ring-2" :style="ringStyle" />
      <span class="absolute inset-0 rounded-full border radar-ring-3" :style="ringStyle" />
      <!-- Center dot -->
      <span
        class="relative z-10 rounded-full animate-pulse"
        :style="{ width: (size / 8) + 'px', height: (size / 8) + 'px', backgroundColor: color }"
      />
    </div>
</template>

<style scoped>
  .radar-ring-1 { animation: radarPing 2.5s cubic-bezier(0, 0, 0.2, 1) infinite; }
  .radar-ring-2 { animation: radarPing 2.5s cubic-bezier(0, 0, 0.2, 1) 0.6s infinite; }
  .radar-ring-3 { animation: radarPing 2.5s cubic-bezier(0, 0, 0.2, 1) 1.2s infinite; }
  
  @keyframes radarPing {
    0% {
      transform: scale(0.5);
      opacity: 0.6;
    }
    100% {
      transform: scale(2.5);
      opacity: 0;
    }
  }
  </style>
  