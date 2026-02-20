<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted, onUnmounted } from 'vue';
import axios from 'axios';

const props = defineProps({
    auth: Object,
});

const playback = ref(props.auth.user.playback);
let syncInterval = null;

const syncSpotify = async () => {
    try {
        const response = await axios.get('/radar/sync');
        playback.value = response.data;
    } catch (error) {
        console.error('Error syncing playback from Spotify:', error);
    }
};

onMounted(() => {
    syncInterval = setInterval(syncSpotify, 10000);
});

onUnmounted(() => {
    clearInterval(syncInterval);
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Radar Musical</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        
                        <h3 class="text-lg font-bold mb-6">¿Qué está sonando?</h3>

                        <div v-if="playback && playback.is_playing" class="flex items-center space-x-4">
                            <img 
                                v-if="playback.album_image_url" 
                                :src="playback.album_image_url" 
                                alt="Album Art" 
                                class="w-20 h-20 rounded shadow-md"
                            >
                            <div>
                                <p class="font-bold text-xl text-green-600">{{ playback.track_name }}</p>
                                <p class="text-gray-600 font-medium">{{ playback.artist_name }}</p>
                            </div>
                        </div>

                        <div v-else class="text-gray-500 italic p-4 bg-gray-50 rounded border border-gray-100">
                            Silencio en la sala... Abre Spotify, dale al play y espera unos segundos.
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>