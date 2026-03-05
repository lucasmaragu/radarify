<script setup>
import { Home, Radar, User } from 'lucide-vue-next'

defineProps({
  activeTab: { type: String, default: 'radar' }
})

defineEmits(['changeTab'])

const tabs = [
  { id: 'radar',   label: 'Radar',   icon: Radar },
]
</script>
<template>
    <nav
      class="fixed inset-x-0 bottom-0 z-50 border-t border-white/[0.06] bg-black/70 backdrop-blur-2xl"
      :style="{ paddingBottom: 'env(safe-area-inset-bottom, 0px)' }"
      role="tablist"
      aria-label="Main navigation"
    >
      <div class="flex items-center justify-around px-2 py-2">
        <button
          v-for="tab in tabs"
          :key="tab.id"
          class="relative flex flex-col items-center gap-0.5 rounded-xl px-5 py-1.5 transition-colors duration-200"
          :class="tab.id === activeTab
            ? 'text-[#1DB954]'
            : 'text-zinc-600 active:text-zinc-400'"
          role="tab"
          :aria-selected="tab.id === activeTab"
          :aria-label="tab.label"
          @click="$emit('changeTab', tab.id)"
        >
          <!-- Active glow dot -->
          <span
            v-if="tab.id === activeTab"
            class="absolute -top-1 h-1 w-1 rounded-full bg-[#1DB954] shadow-[0_0_6px_#1DB954]"
          />
          <component :is="tab.icon" :size="22" :stroke-width="tab.id === activeTab ? 2.2 : 1.6" />
          <span class="text-[10px] font-medium leading-none">{{ tab.label }}</span>
        </button>
      </div>
    </nav>
</template>
  
 
  