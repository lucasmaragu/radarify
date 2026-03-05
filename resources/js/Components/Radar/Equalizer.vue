<script setup>
import { computed } from 'vue'

const props = defineProps({
  size: { type: Number, default: 14 },
  color: { type: String, default: '#1DB954' }
})

const barStyle = computed(() => ({
  width: Math.max(2, props.size / 5.5) + 'px',
  backgroundColor: props.color
}))
</script>

<template>
    <div class="flex items-end gap-[2px]" :style="{ height: size + 'px', width: size + 'px' }">
      <span class="eq-bar eq-bar-1 rounded-full" :style="barStyle" />
      <span class="eq-bar eq-bar-2 rounded-full" :style="barStyle" />
      <span class="eq-bar eq-bar-3 rounded-full" :style="barStyle" />
      <span class="eq-bar eq-bar-4 rounded-full" :style="barStyle" />
    </div>
</template>

<style scoped>
  .eq-bar {
    display: block;
    min-height: 15%;
  }
  
  .eq-bar-1 { animation: eq1 0.8s ease-in-out infinite; }
  .eq-bar-2 { animation: eq2 0.7s ease-in-out infinite; }
  .eq-bar-3 { animation: eq3 0.9s ease-in-out infinite; }
  .eq-bar-4 { animation: eq4 0.75s ease-in-out infinite; }
  
  @keyframes eq1 {
    0%, 100% { height: 20%; }
    25% { height: 80%; }
    50% { height: 40%; }
    75% { height: 100%; }
  }
  @keyframes eq2 {
    0%, 100% { height: 60%; }
    25% { height: 30%; }
    50% { height: 90%; }
    75% { height: 50%; }
  }
  @keyframes eq3 {
    0%, 100% { height: 40%; }
    25% { height: 100%; }
    50% { height: 20%; }
    75% { height: 70%; }
  }
  @keyframes eq4 {
    0%, 100% { height: 80%; }
    25% { height: 50%; }
    50% { height: 100%; }
    75% { height: 30%; }
  }
</style>
  