<template>
    <div class="flex flex-col space-y-8 bg-slate-100">
        <TitleComponent title="Vidéothèque" />

        <div class="content px-6 md:px-16 py-6 md:py-8 flex flex-col space-y-8">
            <div v-if="isLoading" class="flex justify-center items-center py-8">
                <div class="loader"></div>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-10">
                <div v-for="video in videos" :key="video.id" data-aos="fade-up" data-aos-duration="1000"
                    data-aos-once="true">
                    <VideoCard :video="video" @read="handleRead" />
                </div>
            </div>
            <div class="flex justify-center col-span-full">
                <PaginationComponent :current-page="pagination.page" :total-items="pagination.total"
                    :items-per-page="12" :max-visible-pages="5" @page-change="changePage" />
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import { computed, onMounted } from 'vue'
import TitleComponent from '@/components/common/TitleComponent.vue'
import PaginationComponent from '@/components/partials/public/PaginationComponent.vue'
import { useRouter } from 'vue-router'
import { useVideoStore } from '@/stores/video'
import type { TVideo } from '@/requests/video'
import VideoCard from '@/components/partials/public/cards/VideoCard.vue'

export default {
    name: 'VideosView',
    components: { TitleComponent, VideoCard, PaginationComponent },

    setup() {
        const videoStore = useVideoStore()
        const router = useRouter();


        const handleRead = (video: TVideo) => {
            window.open(video.video_path, '_blank')
        }

        onMounted(() => {
            videoStore.listVideos({
                page: 1,
                pageSize: 12,
                orderBy: 'date_video',
                orderDirection: 'desc',
            })
        })


        // Computed properties for store state
        const videos = computed(() => videoStore.videos)
        const isLoading = computed(() => videoStore.loading)
        const pagination = computed(() => videoStore.pagination)

        const changePage = (page: number) => {
            videoStore.listVideos({
                page,
                pageSize: 12,
                orderBy: 'date_video',
                orderDirection: 'desc',
            })
        }

        return {
            videos,
            isLoading,
            pagination,
            changePage,
            handleRead,
        }
    },
}
</script>
<style scoped>
/* Styles pour le loader */
.loader {
    border: 4px solid #f3f3f3;
    /* Couleur de fond */
    border-top: 4px solid #11845a;
    /* Couleur principale */
    border-radius: 50%;
    width: 40px;
    height: 40px;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }

    100% {
        transform: rotate(360deg);
    }
}
</style>
