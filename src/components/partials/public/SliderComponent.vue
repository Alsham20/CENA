<template>
  <div class="relative mx-auto w-full max-w-[1200px] overflow-hidden aspect-[16/9] md:aspect-[21/9]">
    <!-- Slides -->
    <div v-for="(slide, index) in slides" :key="index"
      class="absolute inset-0 w-full h-full transition-opacity duration-500"
      :class="{ 'opacity-0': currentSlide !== index }">
      <!-- Image d'arrière-plan -->
      <img :src="slide.image" :alt="slide.title" class="w-full h-full object-cover" />

      <!-- Contenu -->
      <div class="absolute bottom-0 left-0 right-0 p-4 md:p-6 text-white">
        <div class="mx-auto p-4 md:p-6 bg-gradient-to-r from-[#11845a] to-[#062a1d] opacity-90 space-y-2 md:space-y-4">
          <!-- Tag Actualité -->
          <div>
            <span class="text-xs md:text-md font-bold uppercase tracking-wider me-4">
              Actualité
            </span>
            <span class="text-xs md:text-md font-bold uppercase tracking-wider">
              {{ formatDate(slide.created_at) }}
            </span>
            <span class="text-xs md:text-md font-bold uppercase tracking-wider">
              |
            </span>
            <span class="text-xs md:text-md font-bold uppercase tracking-wider">
              {{ formatTime(slide.created_at) }}
            </span>
          </div>

          <!-- Titre -->
          <h2
            class="text-xs sm:text-xl md:text-2xl lg:text-3xl font-extrabold transition-all duration-500 line-clamp-3 md:line-clamp-2 cursor-pointer"
            :class="{
              'translate-y-0 opacity-100': currentSlide === index,
              'translate-y-4 opacity-0': currentSlide !== index,
            }">
            {{ slide.title }}
          </h2>
          <!-- Navigation -->
          <div class="flex justify-between">
            <div class="flex justify-start">
              <router-link to=""
                class="flex items-center hover:bg-[#EC0001] bg-[#EC0001] rounded-sm text-white hover:text-white px-2 py-1 text-sm font-semibold space-x-1 ease-in duration-300">
                <span class="font-semibold uppercase ">Lire la suite</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-5 h-5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5l6 6m0 0l-6 6m6-6H4.5" />
                </svg>
              </router-link>
            </div>
            <div class="flex space-x-2 justify-end">
              <div>
                <button @click="prevSlide"
                  class="w-6 h-6 md:w-8 md:h-8 rounded-full border border-white flex items-center justify-center text-white hover:bg-white/20 transition-colors"
                  aria-label="Slide précédent">
                  <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                  </svg>
                </button>
              </div>


              <div>
                <button @click="nextSlide"
                  class="w-6 h-6 md:w-8 md:h-8 rounded-full border border-white flex items-center justify-center text-white hover:bg-white/20 transition-colors"
                  aria-label="Slide suivant">
                  <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                  </svg>
                </button>
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
import { ref, onMounted, onUnmounted } from 'vue'
interface Slide {
  image: string
  title: string
  link: string
  created_at: string
}
const props = defineProps({
  slides: {
    type: Array<Slide>,
    required: true,
  },
  autoplayInterval: {
    type: Number,
    default: 5000,
  },
})

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
  currentSlide.value = (currentSlide.value + 1) % props.slides.length
}

const prevSlide = () => {
  currentSlide.value = (currentSlide.value - 1 + props.slides.length) % props.slides.length
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