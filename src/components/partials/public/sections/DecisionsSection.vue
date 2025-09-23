<!-- DecisionsRecentes.vue -->
<template>
    <section class="py-4 md:py-8 space-y-4 md:space-y-6 m-auto w-[90%]">
        <!-- Titre de la section -->
        <div class="mb-8 flex items-center w-full">
            <h2 class="text-[#0E6258] text-xl md:text-3xl xl:text-5xl font-extrabold">Décisions récentes</h2>
            <div class="flex-1 border-t border-gray-300 ml-4"></div>
        </div>

        <!-- Container du carrousel -->
        <div data-aos="fade-up-left" class="overflow-hidden mb-8">
            <div class="flex transition-transform duration-500 ease-in-out"
                :style="{ transform: `translateX(-${currentIndex * slideWidth}%)` }">
                <div v-for="(decision, index) in decisions" :key="decision.id" :class="cardClasses">
                    <DecisionCard :decision="decision" @read="handleRead" @download="handleDownload" />
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <div class="flex justify-start items-center gap-2">
            <button @click="handlePrevious" :disabled="currentIndex === 0"
                class="w-7 h-7 text-blue-800 disabled:opacity-50 disabled:cursor-not-allowed  transition-all duration-300 flex items-center justify-center text-lg font-bold hover:scale-105"
                aria-label="Décision précédente">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
                    <path fill="#0E6258"
                        d="M169.4 297.4C156.9 309.9 156.9 330.2 169.4 342.7L361.4 534.7C373.9 547.2 394.2 547.2 406.7 534.7C419.2 522.2 419.2 501.9 406.7 489.4L237.3 320L406.6 150.6C419.1 138.1 419.1 117.8 406.6 105.3C394.1 92.8 373.8 92.8 361.3 105.3L169.3 297.3z" />
                </svg>
            </button>

            <button @click="handleNext" :disabled="currentIndex >= maxIndex"
                class="w-7 h-7 text-blue-800 disabled:opacity-50 disabled:cursor-not-allowed  transition-all duration-300 flex items-center justify-center text-lg font-bold hover:scale-105"
                aria-label="Décision suivante">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
                    <path fill="#0E6258"
                        d="M471.1 297.4C483.6 309.9 483.6 330.2 471.1 342.7L279.1 534.7C266.6 547.2 246.3 547.2 233.8 534.7C221.3 522.2 221.3 501.9 233.8 489.4L403.2 320L233.9 150.6C221.4 138.1 221.4 117.8 233.9 105.3C246.4 92.8 266.7 92.8 279.2 105.3L471.2 297.3z" />
                </svg>
            </button>
        </div>
    </section>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted, computed } from 'vue'
import DecisionCard from '../cards/DecisionCard.vue'
import { decisions } from '@/data'
import type { DecisionType } from '@/types/decision'

// État réactif
const currentIndex = ref(0)
const autoSlideInterval = ref<number | null>(null)
const timeLeft = ref(5)
const timerInterval = ref<number | null>(null)
const isPaused = ref(false)
const screenWidth = ref(typeof window !== 'undefined' ? window.innerWidth : 1024)
// Configuration responsive
const cardsPerView = computed(() => {
    if (screenWidth.value < 768) return 1
    if (screenWidth.value < 1024) return 2
    return 3
})

const slideWidth = computed(() => 100 / cardsPerView.value)
const maxIndex = computed(() => Math.max(0, decisions.length - cardsPerView.value))
const totalPages = computed(() => maxIndex.value + 1)

const cardClasses = computed(() => [
    'flex-shrink-0',
    cardsPerView.value === 1 ? 'w-full px-2' :
        cardsPerView.value === 2 ? 'w-1/2 px-2' : 'w-1/3 px-2'
])

// Navigation functions
const goToPrevious = (): void => {
    if (currentIndex.value > 0) {
        currentIndex.value--
    }
}

const goToNext = (): void => {
    if (currentIndex.value < maxIndex.value) {
        currentIndex.value++
    } else {
        currentIndex.value = 0
    }
}

// Timer management
const startTimer = (): void => {
    timeLeft.value = 5
    timerInterval.value = window.setInterval(() => {
        timeLeft.value--
        if (timeLeft.value <= 0) {
            timeLeft.value = 5
        }
    }, 1000)
}

const stopTimer = (): void => {
    if (timerInterval.value) {
        clearInterval(timerInterval.value)
        timerInterval.value = null
    }
}

// Auto-slide management
const startAutoSlide = (): void => {
    isPaused.value = false
    startTimer()
    autoSlideInterval.value = window.setInterval(() => {
        goToNext()
    }, 5000)
}

const stopAutoSlide = (): void => {
    isPaused.value = true
    stopTimer()
    if (autoSlideInterval.value) {
        clearInterval(autoSlideInterval.value)
        autoSlideInterval.value = null
    }
}

const restartAutoSlide = (): void => {
    stopAutoSlide()
    startAutoSlide()
}

// Event handlers
const handlePrevious = (): void => {
    goToPrevious()
    restartAutoSlide()
}

const handleNext = (): void => {
    goToNext()
    restartAutoSlide()
}

const handleRead = (decision: DecisionType): void => {
    console.log('Lire la décision:', decision.number)
    // Votre logique ici
}

const handleDownload = (decision: DecisionType): void => {
    console.log('Télécharger la décision:', decision.number)
    // Votre logique ici
}

// Resize handler
const handleResize = (): void => {
    screenWidth.value = window.innerWidth
    // Ajuster l'index si nécessaire
    if (currentIndex.value > maxIndex.value) {
        currentIndex.value = maxIndex.value
    }
}

// Lifecycle
onMounted(() => {
    if (typeof window !== 'undefined') {
        window.addEventListener('resize', handleResize)
        startAutoSlide()
    }
})

onUnmounted(() => {
    if (typeof window !== 'undefined') {
        window.removeEventListener('resize', handleResize)
    }
    stopAutoSlide()
})


</script>
<style scoped>
/* Animations personnalisées si nécessaire */
.slide-enter-active,
.slide-leave-active {
    transition: all 0.5s ease;
}

.slide-enter-from {
    transform: translateX(100%);
}

.slide-leave-to {
    transform: translateX(-100%);
}
</style>