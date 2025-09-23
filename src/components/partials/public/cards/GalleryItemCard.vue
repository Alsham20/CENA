<script setup lang="ts">
import type { GalleryItemType } from '@/types/gallery_item';



interface Props {
    item: GalleryItemType
}

const props = defineProps<Props>()

const emit = defineEmits<{
    openModal: [index: number]
}>()

const handleClick = () => {
    emit('openModal', props.item.id)
}
</script>

<template>
    <div data-aos="zoom-out" class="relative group cursor-pointer overflow-hidden rounded-sm shadow-md hover:shadow-lg transition-all duration-700"
        @click="handleClick">
        <!-- Image -->
        <img :src="item.imageUrl" :alt="item.title"
            class="w-full h-56 object-cover group-hover:scale-105 transition-transform duration-300" />

        <!-- Overlay -->
        <div
            class="absolute inset-0 bg-gray-900 bg-opacity-30 flex items-center justify-center transition-all duration-300">
            <div class="relative w-full h-full flex items-center justify-center">
                <!-- Texte -->
                <h3 class="text-white font-medium text-base text-center px-2 line-clamp-2 absolute transition-all duration-300 ease-in-out
                    group-hover:-translate-y-full group-hover:opacity-0">
                    <!-- {{ item.title }} -->
                </h3>
                <!-- Icône -->
                <div class="absolute opacity-0 translate-y-full group-hover:opacity-100 group-hover:translate-y-0 
                    transition-all duration-300 ease-in-out w-12 h-12 bg-transparent bg-opacity-80 rounded-full 
                    flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
</template>
