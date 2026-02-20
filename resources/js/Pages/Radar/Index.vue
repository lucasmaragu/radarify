<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted, onUnmounted } from 'vue';
import axios from 'axios';

const props = defineProps({
    initialPlaybacks: Array,
});

const playbacks = ref(props.initialPlaybacks);
let syncInterval = null;

const syncRadar = async () => {
    try {
        const response = await axios.get('/radar/sync');
        playbacks.value = response.data.playbacks;
    } catch (error) {
        console.error('Error sincronizando el radar:', error);
    }
};

onMounted(() => {
    syncInterval = setInterval(syncRadar, 10000);
});

onUnmounted(() => {
    clearInterval(syncInterval);
});
</script>

<template>
    <Head title="Radar Global" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Radar Global</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
                <div v-if="playbacks && playbacks.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    
                    <div 
                        v-for="playback in playbacks" 
                        :key="playback.id" 
                        class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex flex-col items-center text-center"
                    >
                        <div class="mb-4">
                            <img 
                                v-if="playback.user.avatar" 
                                :src="playback.user.avatar" 
                                alt="Avatar" 
                                class="w-12 h-12 rounded-full mx-auto mb-2 border-2 border-green-500"
                            >
                            <div v-else class="w-12 h-12 rounded-full mx-auto mb-2 bg-gray-200 flex items-center justify-center border-2 border-green-500">
                                <span class="text-gray-500 font-bold">{{ playback.user.name.charAt(0) }}</span>
                            </div>
                            <p class="font-semibold text-gray-800">{{ playback.user.name }}</p>
                            <p class="text-xs text-gray-500">escuchando ahora</p>
                        </div>

                        <img 
                            v-if="playback.album_image_url" 
                            :src="playback.album_image_url" 
                            alt="Album Art" 
                            class="w-32 h-32 rounded shadow-md mb-3"
                        >
                        <p class="font-bold text-lg text-gray-900 line-clamp-1">{{ playback.track_name }}</p>
                        <p class="text-sm text-gray-600 line-clamp-1">{{ playback.artist_name }}</p>
                    </div>

                </div>

                <div v-else class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center text-gray-500">
                    <p>El radar está en silencio... Nadie está escuchando música ahora mismo.</p>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>