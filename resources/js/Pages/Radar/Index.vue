<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import axios from 'axios';

const nearbyUsers = ref([]);
const isLoading = ref(true);
let radarInterval = null;

const scanRadar = async () => {
    try {
        const response = await axios.get('/radar/sync');
        nearbyUsers.value = response.data.playbacks;
    } catch (error) {
        console.error("Error al escanear el radar:", error);
    } finally {
        isLoading.value = false;
    }
};

onMounted(() => {
    scanRadar();
    radarInterval = setInterval(scanRadar, 10000);
});

onUnmounted(() => {
    clearInterval(radarInterval);
});
</script>

<template>
    <Head title="Radar de Proximidad" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Radar (100m)</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    
                    <div v-if="isLoading" class="text-center text-gray-500">
                        Escaneando la zona...
                    </div>

                    <div v-else-if="nearbyUsers.length === 0" class="text-center text-gray-500">
                        No hay nadie escuchando música cerca de ti en este momento.
                    </div>

                    <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        
                        <div v-for="playback in nearbyUsers" :key="playback.id" 
                             class="flex items-center p-4 border rounded-lg shadow-sm bg-gray-50">
                            
                            <img :src="playback.album_image_url" 
                                 class="w-16 h-16 rounded-md mr-4" 
                                 alt="Album cover">
                            
                            <div class="flex-1">
                                <p class="text-xs text-gray-400 mb-1">
                                    {{ playback.user.name }} • A {{ Math.round(playback.distance_meters) }}m
                                </p>
                                <h3 class="font-bold text-gray-900 truncate w-48">
                                    {{ playback.track_name }}
                                </h3>
                                <p class="text-sm text-gray-600 truncate w-48">
                                    {{ playback.artist_name }}
                                </p>
                            </div>
                            
                            <div class="flex space-x-1 h-4">
                                <div class="w-1 bg-green-500 animate-pulse"></div>
                                <div class="w-1 bg-green-500 animate-pulse delay-75"></div>
                                <div class="w-1 bg-green-500 animate-pulse delay-150"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>