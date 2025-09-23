<template>
    <div class="relative mx-auto w-full max-w-full overflow-hidden aspect-[16/9] md:aspect-[21/9]">
        <!-- Slides -->
        <div v-for="(slide, index) in slides" :key="index"
            class="absolute inset-0 w-full h-full transition-opacity duration-500"
            :class="{ 'opacity-0': currentSlide !== index }">
            <!-- Image d'arrière-plan -->
            <img :src="slide.imageUrl" :alt="slide.title" class="w-full h-full object-cover" />

            <!-- Contenu -->
            <div 
                class="absolute inset-0 bg-gray-900 bg-opacity-30 flex items-center justify-center transition-all duration-300">
                <div class="absolute bottom-0 left-0 right-0 p-4 md:p-6 text-white">
                    <div
                        class="mx-auto p-4 md:p-8 space-y-4 lg:space-y-6 xl:space-y-10">
                        <!-- Tag Actualité -->
                        <div>
                            <span class="xl:text-lg font-extrabold uppercase tracking-wider me-4">
                                Actualité
                            </span>
                            <span class="xl:text-lg font-extrabold uppercase tracking-wider">
                                {{ formatDate(slide.created_at) }}
                            </span>
                            <span class="xl:text-lg font-extrabold uppercase tracking-wider">
                                |
                            </span>
                            <span class="xl:text-lg font-extrabold uppercase tracking-wider">
                                {{ formatTime(slide.created_at) }}
                            </span>
                        </div>

                        <!-- Titre -->
                        <h2 class="text-xl md:text-2xl lg:text-4xl xl:text-5xl transition-all duration-500 line-clamp-3 cursor-pointer"
                            :class="{
                                'translate-y-0 opacity-100': currentSlide === index,
                                'translate-y-4 opacity-0': currentSlide !== index,
                            }">
                            <span class="font-extrabold leading-tight">
                                {{ slide.title }}
                            </span>
                        </h2>
                        <!-- Navigation -->
                        <div class="flex justify-between">
                            <div class="flex justify-start">
                                <router-link to=""
                                    class="flex items-center hover:bg-[#EC0001] bg-[#EC0001] rounded-sm text-white hover:text-white px-4 py-1 text-sm xl:text-lg font-semibold space-x-1 ease-in duration-300">
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
                                        <svg class="w-4 h-4 xl:w-8 xl:h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 19l-7-7 7-7" />
                                        </svg>
                                    </button>
                                </div>


                                <div>
                                    <button @click="nextSlide"
                                        class="w-6 h-6 md:w-8 md:h-8 xl:w-12 xl:h-12 rounded-full border xl:border-2 border-white flex items-center justify-center text-white hover:bg-white/20 transition-colors"
                                        aria-label="Slide suivant">
                                        <svg class="w-4 h-4 xl:w-8 xl:h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
import { faker } from '@faker-js/faker'
import { ref, onMounted, onUnmounted } from 'vue'
interface Slide {
    id: string
    imageUrl: string
    title: string
    created_at: string
}

const props = defineProps({

    autoplayInterval: {
        type: Number,
        default: 5000,
    },
})

const slides: Slide[] = [
    {
        id: faker.string.uuid(),
        title: 'Briefing des équipes de la CENA dans le cadre de la mission de recrutement des Membres de Postes de Vote.',
        imageUrl: '/assets/img/news/news_2.jpg',
        created_at: '2025-09-04 21:52:44',
    },
    {
        id: faker.string.uuid(),
        title: 'Présidentielle 2026 : la CENA lance la délivrance des formulaires de parrainage',
        imageUrl: '/assets/img/news/news_3.jpg',
        created_at: '2025-09-02 10:53:46',
    },
    {
        id: faker.string.uuid(),
        title: 'La Cena échange avec les partis politiques sur le suivi du code électoral et la plateforme e-Delegue',
        imageUrl: '/assets/img/news/news_1.jpg',
        created_at: '2025-08-28 14:16:02',
    }
];

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
    currentSlide.value = (currentSlide.value + 1) % slides.length
}

const prevSlide = () => {
    currentSlide.value = (currentSlide.value - 1 + slides.length) % slides.length
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