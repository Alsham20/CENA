<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue'
import { galleryItems } from '@/data';
import GalleryItemCard from '../cards/GalleryItemCard.vue';

// État du modal et navigation
const isModalOpen = ref(false)
const currentIndex = ref(0)
const galleryContainer = ref<HTMLElement>()

// Ouvrir le modal
const openModal = (index: number) => {
    currentIndex.value = index -1
    isModalOpen.value = true
    document.body.style.overflow = 'hidden'
}

// Fermer le modal
const closeModal = () => {
    isModalOpen.value = false
    document.body.style.overflow = 'auto'
}

// Navigation dans le modal
const goToPrevious = () => {
    currentIndex.value = currentIndex.value > 0 ? currentIndex.value - 1 : galleryItems.length - 1
}

const goToNext = () => {
    currentIndex.value = currentIndex.value < galleryItems.length - 1 ? currentIndex.value + 1 : 0
}

// Navigation du carrousel principal
const scrollLeft = () => {
    if (galleryContainer.value) {
        galleryContainer.value.scrollBy({ left: -320, behavior: 'smooth' })
    }
}

const scrollRight = () => {
    if (galleryContainer.value) {
        galleryContainer.value.scrollBy({ left: 320, behavior: 'smooth' })
    }
}

// Gestion clavier
const handleKeydown = (event: KeyboardEvent) => {
    if (!isModalOpen.value) return

    switch (event.key) {
        case 'Escape':
            closeModal()
            break
        case 'ArrowLeft':
            goToPrevious()
            break
        case 'ArrowRight':
            goToNext()
            break
    }
}

onMounted(() => {
    document.addEventListener('keydown', handleKeydown)
})

onUnmounted(() => {
    document.removeEventListener('keydown', handleKeydown)
    document.body.style.overflow = 'auto'
})
</script>

<template>
    <section class="py-4 md:py-8 space-y-4 md:space-y-6 m-auto w-[90%]">
        <!-- Titre de la section -->
        <div class="flex items-center w-full">
            <h2 class="text-[#0E6258] text-sm sm:text-xl md:text-3xl xl:text-5xl font-extrabold">Galerie photos</h2>
            <div class="flex-1 border-t border-gray-200 ml-4"></div>
        </div>

    <div class="relative flex items-center">
        <!-- Bouton gauche -->
        <button @click="scrollLeft"
            class="flex-shrink-0 w-7 h-7 bg-[#0E6258] text-white rounded-sm flex items-center justify-center hover:bg-[#11845a] transition-colors shadow-lg">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </button>

        <!-- Conteneur scrollable -->
        <div ref="galleryContainer" class="flex-1 mx-2 overflow-x-auto scrollbar-hide py-4"
            style="scroll-behavior: smooth; scrollbar-width: none; -ms-overflow-style: none;">
            <div class="flex gap-2">
                <div v-for="(item, index) in galleryItems" :key="item.id" class="flex-shrink-0 w-60">
                    <GalleryItemCard :item="item" :index="index" @open-modal="openModal" />
                </div>
            </div>
        </div>

        <!-- Bouton droit -->
        <button @click="scrollRight"
            class="flex-shrink-0 w-7 h-7 bg-[#0E6258] text-white rounded-sm flex items-center justify-center hover:bg-[#11845a] transition-colors shadow-lg">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
    </div>

        <!-- Modal de prévisualisation -->
        <Teleport to="body">
            <div v-if="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-90"
                @click="closeModal">
                <!-- Bouton fermer -->
                <button @click="closeModal"
                    class="absolute top-4 right-4 z-60 w-10 h-10 bg-white bg-opacity-20 text-white rounded-full flex items-center justify-center hover:bg-opacity-30 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <!-- Navigation précédente -->
                <button @click.stop="goToPrevious"
                    class="absolute left-4 top-1/2 -translate-y-1/2 z-60 w-12 h-12 bg-white bg-opacity-20 text-white rounded-full flex items-center justify-center hover:bg-opacity-30 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                <!-- Image principale -->
                <div class="max-w-xl  mx-auto p-4" @click.stop>
                                        <!-- Informations de l'image -->
                    <div class="mt-4 text-center text-white">
                        <h3 class="text-base font-semibold mb-2">{{ galleryItems[currentIndex].title }}</h3>
                        <!-- <p v-if="galleryItems[currentIndex].description" class="text-gray-300">
                            {{ galleryItems[currentIndex].description }}
                        </p> -->
                        <p class="text-sm text-gray-400 mt-2">
                            {{ currentIndex + 1 }} / {{ galleryItems.length }}
                        </p>
                    </div>
                    <img :src="galleryItems[currentIndex].imageUrl" :alt="galleryItems[currentIndex].title"
                        class="w-full h-full object-contain" />
                </div>

                <!-- Navigation suivante -->
                <button @click.stop="goToNext"
                    class="absolute right-4 top-1/2 -translate-y-1/2 z-60 w-12 h-12 bg-white bg-opacity-20 text-white rounded-full flex items-center justify-center hover:bg-opacity-30 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </Teleport>
    </section>
</template>

<style scoped>
.scrollbar-hide {
    -ms-overflow-style: none;
    scrollbar-width: none;
}

.scrollbar-hide::-webkit-scrollbar {
    display: none;
}
</style>