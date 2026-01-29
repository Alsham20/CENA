<template>
    <div class="relative mx-auto w-full max-w-full overflow-hidden aspect-[16/9] md:aspect-[21/9]">
        <!-- Slides -->
        <div v-for="(slide, index) in slides" :key="index"
            class="absolute inset-0 w-full h-full transition-opacity duration-500"
            :class="{ 'opacity-0': currentSlide !== index }">
            <!-- Placeholder -->
            <img src="/src/assets/img/images-removebg-preview.png" alt="Loading" class="absolute inset-0 w-full h-full object-contain"
                :class="{ hidden: imageLoaded[index] && !imageError[index] }" />
            <!-- Image d'arrière-plan -->
            <img :src="slide.image?.base_url + (slide.image?.path || '') + '/' + (slide.image?.name || '')" alt=""
                class="w-full h-full object-cover" :class="{ hidden: imageError[index] }" @load="onImageLoad(index)"
                @error="onImageError(index)" />

            <!-- Contenu -->
            <div
                class="absolute inset-0 bg-gray-900 bg-opacity-30 flex items-center justify-center transition-all duration-300">
                <div class="absolute bottom-0 left-0 right-0 p-4 md:p-6 text-white">
                    <div class="mx-auto p-4 md:p-8 space-y-4 lg:space-y-6 xl:space-y-10">
                        <!-- Tag Actualité -->
                        <div>
                            <span class="text-xs sm:text-sm lg:text-lg font-extrabold uppercase tracking-wider me-4">
                                Actualité
                            </span>
                            <span class="text-xs sm:text-sm lg:text-lg font-extrabold uppercase tracking-wider">
                                {{ formatDate(slide.created_at) }}
                            </span>
                            <span class="text-xs sm:text-sm lg:text-lg font-extrabold uppercase tracking-wider">
                                |
                            </span>
                            <span class="text-xs sm:text-sm lg:text-lg font-extrabold uppercase tracking-wider">
                                {{ formatTime(slide.created_at) }}
                            </span>
                        </div>

                        <!-- Titre -->
                        <h2 class="text-sm sm:text-2xl lg:text-4xl xl:text-5xl transition-all duration-500 line-clamp-3 cursor-pointer"
                            :class="{
                                'translate-y-0 opacity-100': currentSlide === index,
                                'translate-y-4 opacity-0': currentSlide !== index,
                            }">
                            <span class="font-extrabold leading-tight">
                                {{ slide.title.slice(0, 100) }}
                                {{ slide.title.length > 100 ? '...' : '' }}
                            </span>
                        </h2>
                        <!-- Navigation -->
                        <div class="flex justify-between">
                            <div class="flex justify-start">
                                <router-link :to="'/articles/' + slide.slug"
                                    class="flex items-center hover:bg-[#EC0001] bg-[#EC0001] rounded-sm text-white hover:text-white px-2 lg:px-4 py-1 text-xs xl:text-lg font-semibold space-x-1 ease-in duration-300">
                                    <span class="font-bold uppercase ">Lire la suite</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M13.5 4.5l6 6m0 0l-6 6m6-6H4.5" />
                                    </svg>
                                </router-link>
                            </div>
                            <div class="flex space-x-2 justify-end">
                                <div>
                                    <button @click="prevSlide"
                                        class="w-6 h-6 md:w-8 md:h-8 xl:w-12 xl:h-12 rounded-full border xl:border-2 border-white flex items-center justify-center text-white hover:bg-white/20 transition-colors"
                                        aria-label="Slide précédent">
                                        <svg class="w-4 h-4 xl:w-8 xl:h-8" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 19l-7-7 7-7" />
                                        </svg>
                                    </button>
                                </div>


                                <div>
                                    <button @click="nextSlide"
                                        class="w-6 h-6 md:w-8 md:h-8 xl:w-12 xl:h-12 rounded-full border xl:border-2 border-white flex items-center justify-center text-white hover:bg-white/20 transition-colors"
                                        aria-label="Slide suivant">
                                        <svg class="w-4 h-4 xl:w-8 xl:h-8" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script setup lang="ts">
// Le script reste identique à la version précédente
import { useArticleStore } from '@/stores/article'
import { ref, onMounted, onUnmounted, computed } from 'vue'

const articleStore = useArticleStore()
const slides = computed(() => articleStore.articles.slice(0, 3))

const props = defineProps({

    autoplayInterval: {
        type: Number,
        default: 5000,
    },
})

// États pour suivre le chargement et les erreurs des images
const imageLoaded = ref<boolean[]>(new Array(slides.value.length).fill(false))
const imageError = ref<boolean[]>(new Array(slides.value.length).fill(false))

const onImageLoad = (index: number) => {
    imageLoaded.value[index] = true
    imageError.value[index] = false
}

const onImageError = (index: number) => {
    imageError.value[index] = true
    imageLoaded.value[index] = false
    // Optionnel : logger l'erreur ou notifier un service de monitoring
    console.warn(`Failed to load image for slide ${index}`)
}

// Fonction pour extraire la date formatée
function formatDate(dateStr: string): string {
    const date = new Date(dateStr)
    if (isNaN(date.getTime())) return "Date invalide"

    const day = String(date.getDate()).padStart(2, '0')
    const month = date.toLocaleString('en-US', { month: 'short' }) // Sep, Oct, ...
    const year = date.getFullYear()

    return `${day} ${month} ${year}`
}

// Fonction pour extraire uniquement l'heure
function formatTime(dateStr: string): string {
    const date = new Date(dateStr)
    if (isNaN(date.getTime())) return "Heure invalide"

    const hours = String(date.getHours()).padStart(2, '0')
    const minutes = String(date.getMinutes()).padStart(2, '0')

    return `${hours}:${minutes}`
}

const currentSlide = ref(0)
let autoplayTimer: number | null = null

const nextSlide = () => {
    currentSlide.value = (currentSlide.value + 1) % slides.value.length
}

const prevSlide = () => {
    currentSlide.value = (currentSlide.value - 1 + slides.value.length) % slides.value.length
}

const startAutoplay = () => {
    autoplayTimer = setInterval(nextSlide, props.autoplayInterval)
}

const stopAutoplay = () => {
    if (autoplayTimer) {
        clearInterval(autoplayTimer)
    }
}

/*const handleMouseEnter = () => {
  stopAutoplay()
}
 
const handleMouseLeave = () => {
  startAutoplay()
}*/

onMounted(() => {
    startAutoplay()
})

onUnmounted(() => {
    stopAutoplay()
})
</script>

<style scoped></style>