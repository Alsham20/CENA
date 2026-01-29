<script setup lang="ts">
import { useVideoStore } from '@/stores/video';
import { computed } from 'vue';
import type { TVideo } from '@/requests/video';
import VideoCard from '../cards/VideoCard.vue';
import { onMounted } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();


const handleRead = (video: TVideo) => {
  window.open(video.video_path, '_blank')
}

const goToVideotheque = () => {
  router.push('/videos')
}
const videoStore = useVideoStore()
const videos = computed(() => videoStore.videos)

onMounted(() => {
  videoStore.listVideos({
    page: 1,
    pageSize: 20,
    orderBy: 'date_video',
    orderDirection: 'desc',
  })
})

</script>

<template>
  <div class="py-4 md:py-8 m-auto w-[90%] space-y-4 md:space-y-10">
    <div class="flex justify-between items-center">
      <h1 class="text-[#0E6258] text-sm sm:text-xl md:text-3xl xl:text-5xl font-extrabold">Vidéos récentes</h1>
      <div class="flex-1 border-t border-gray-300 mx-4"></div>
      <div class="flex items-center space-x-4 text-center">
        <span class="text-[#11845a] text-sm xl:text-xl font-medium invisible md:visible">TOUTES LES VIDÉOS</span>
        <button class="p-2 xl:p-4 rounded-full bg-[#11845a] text-white" @click="goToVideotheque()">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-6 md:w-6 xl:h-8 xl:w-8" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 4.5c-4.99 0-9.27 3.11-11 7.5 1.73 4.39 6.01 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6.01-7.5-11-7.5z" />
            <circle cx="12" cy="12" r="3" stroke-width="2" />
          </svg>
        </button>
      </div>
    </div>
    <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-8">
      <VideoCard v-for="video in videos.slice(0, 3)" :key="video.id" :video="video" @read="handleRead" />
    </div>
  </div>
</template>