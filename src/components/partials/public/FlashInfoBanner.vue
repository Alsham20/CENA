<template>
    <div class="bg-white mx-auto w-full max-w-full shadow-md overflow-hidden">
        <div class="flex items-center h-16 xl:h-24"> <!-- hauteur fixée ici -->
            <!-- Étiquette Flash Info -->
            <div class="bg-[#EC0001] h-full px-4 py-2 flex-shrink-0 relative z-10 text-white mr-4 flex items-center">
                <span class="font-bold xl:text-lg uppercase">FLASH INFO</span>

                <!-- Forme triangulaire -->
                <div
                    class="absolute right-0 w-0 h-0 border-l-[15px] border-[#EC0001] border-t-[15px] border-t-transparent border-b-[15px] border-b-transparent translate-x-full">
                </div>

            </div>

            <div class="flash-info-content-wrapper ml-4">
                <transition name="slide">
                    <div :key="currentMessageIndex" class="flash-info-content">
                        <RouterLink to="#"
                            class="text-gray-700 text-sm xl:text-lg font-normal italic hover:text-[#EC0001]">{{
                                infos[currentMessageIndex].title }}</RouterLink>
                    </div>
                </transition>
            </div>
            <!-- Boutons de navigation -->
            <div class="flex items-center space-x-2 px-4">
                <button @click="prevMessage" class="p-1 rounded-full hover:bg-gray-200 transition-colors"
                    :disabled="isTransitioning" :class="{ 'opacity-50 cursor-not-allowed': isTransitioning }">
                    <svg class="w-6 h-6 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
                <button @click="nextMessage" class="p-1 rounded-full hover:bg-gray-200 transition-colors"
                    :disabled="isTransitioning" :class="{ 'opacity-50 cursor-not-allowed': isTransitioning }">

                    <svg class=" w-6 h-6 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import type { TArticle } from '@/requests/article';
import { ref, onMounted, onUnmounted } from 'vue';
import { RouterLink } from 'vue-router';

const props = defineProps({
    infos: {
        type: Array<TArticle>,
        required: true,
    },
})

const currentMessageIndex = ref(0);
let intervalId: number | null = null;
const isTransitioning = ref(false); // New state to prevent rapid clicks during transition

const startSliding = () => {
    intervalId = setInterval(() => {
        nextMessage();
    }, 8000); // Change message every 5 seconds
};

const nextMessage = () => {
    if (isTransitioning.value) return; // Prevent action if a transition is in progress
    isTransitioning.value = true;
    currentMessageIndex.value = (currentMessageIndex.value + 1) % props.infos.length;
    setTimeout(() => {
        isTransitioning.value = false; // Reset after transition duration
    }, 500); // Adjust this to match your CSS transition duration
};

const prevMessage = () => {
    if (isTransitioning.value) return; // Prevent action if a transition is in progress
    isTransitioning.value = true;
    currentMessageIndex.value = (currentMessageIndex.value - 1 + props.infos.length) % props.infos.length;
    setTimeout(() => {
        isTransitioning.value = false; // Reset after transition duration
    }, 500); // Adjust this to match your CSS transition duration
};

onMounted(() => {
    startSliding();
});

onUnmounted(() => {
    if (intervalId) {
        clearInterval(intervalId);
    }
});
</script>

<style scoped>
.flash-info-content-wrapper {
    @apply flex-grow overflow-hidden relative flex items-center;
    /* Added flex and items-center here */
    min-height: 2.8em;
    line-height: 1.4em;
}

.flash-info-content {
    @apply absolute w-full;
    overflow: hidden;
    text-overflow: ellipsis;
    justify-items: center;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

/* Vue Transition Styles */
.slide-enter-active,
.slide-leave-active {
    transition: transform 2s ease-in-out, opacity 2s ease-in-out;
}

.slide-enter-from {
    transform: translateX(100%);
    opacity: 0;
}

.slide-leave-to {
    transform: translateX(-100%);
    opacity: 0;
}

/* Optional: To make the incoming text appear smoothly from the right */
.slide-enter-to {
    transform: translateX(0%);
    opacity: 1;
}
</style>