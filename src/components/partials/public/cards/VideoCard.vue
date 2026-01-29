<!-- VideoCard.vue -->
<template>
    <div class="space-y-4">
        <div class="cursor-pointer relative overflow-hidden rounded-none group">
            <!-- Badge Catégorie -->
            <div
                class="absolute top-2 right-4 z-10 bg-[#0E6258] text-white px-1 py-0.5 rounded-sm text-xs font-semibold">
                {{ video.categories?.label }}
            </div>

            <!-- Conteneur de l'image avec effet de zoom -->
            <div class="relative aspect-video overflow-hidden">
                <img :src="getYoutubeThumbnail(video.video_path)" alt=""
                    class="w-full h-full object-cover transform transition-transform duration-1000 group-hover:scale-110" />
                <!-- Overlay avec bouton play -->
                <div class="absolute inset-0 flex items-center justify-center">
                    <button @click="$emit('read', video)"
                        class="w-12 h-12 rounded-full bg-white/80 flex items-center justify-center transform transition-transform duration-900 group-hover:scale-110">
                        <svg class="w-8 h-8 text-gray-800" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8 5v14l11-7z" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Contenu textuel -->
            <div
                class="flex justify-between items-center absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-black/60 px-4 py-2">
                <div class=" text-white px-1 py-0.5 rounded-sm text-xs xl:text-lg">
                    {{ video.activities?.label }}
                </div>
                <div class="text-xs xl:text-lg float-end text-white">
                    {{ formatDate(video.date_video) }}
                </div>
            </div>
        </div>
        <a class="text-[#2c2c2c] text-sm xl:text-lg font-bold">
                      {{ video.title.slice(0, 50) }}
          {{ video.title.length > 50 ? '...' : '' }}
        </a>
    </div>
</template>
<script setup lang="ts">
import type { TVideo } from '@/requests/video';
import { computed } from 'vue';

interface Props {
    video: TVideo
}

interface Emits {
    read: [video: TVideo]
}

const props = defineProps<Props>()
defineEmits<Emits>()

const thumbnailUrl = computed(() =>
    `https://img.youtube.com/vi/${props.video.video_path}/maxresdefault.jpg`);

const videoUrl = computed(() =>
    `https://www.youtube.com/watch?v=${props.video.video_path}`);

const getYoutubeThumbnail = (url : string) => {
    const match = url.match(/(?:youtube\.com.*v=|youtu\.be\/)([^&]+)/)
    return match ? `https://img.youtube.com/vi/${match[1]}/hqdefault.jpg` : ""
}

const formatDate = (date: string) => {
    return new Date(date).toLocaleDateString('fr-FR', {
        day: 'numeric',
        month: 'long',
        year: 'numeric',
    })
}
</script>