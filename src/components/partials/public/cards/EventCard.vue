<script setup lang="ts">
import type { EventType } from '@/types/event';


interface Props {
    event: EventType
}

const props = defineProps<Props>()

// Formatage de la date
const formatDate = (dateString: string) => {
    const date = new Date(dateString)
    const options: Intl.DateTimeFormatOptions = {
        day: '2-digit',
        month: 'short',
        year: 'numeric'
    }
    return date.toLocaleDateString('fr-FR', options)
}

// Couleur par défaut pour la catégorie
const getCategoryColor = (color?: string) => {
    return color || 'bg-red-600'
}
</script>

<template>
    <div data-aos="fade-up"
     data-aos-duration="1000"
        class="flex flex-col lg:flex-row bg-white border-b-4 border-b-[#11845a] shadow-md overflow-hidden cursor-pointer p-4">
        <!-- Image et catégorie -->
        <div class="relative flex-shrink-0 w-full lg:w-40 xl:w-56">
            <img :src="event.imageUrl" :alt="event.title" class="w-full lg:h-40 h-48 xl:h-56 object-cover" />
            <!-- Badge de catégorie -->
            <div :class="getCategoryColor(event.categoryColor)"
                class="absolute bottom-3 left-3 px-3 py-1 text-white text-xs xl:text-lg font-medium rounded">
                {{ event.category }}
            </div>
        </div>

        <!-- Contenu -->
        <div class="flex-1 pt-4 lg:px-4 flex flex-col justify-center">
            <!-- Titre -->
            <h3 class="text-sm xl:text-lg font-bold text-gray-800 mb-4 line-clamp-2">
                {{ event.title }}
            </h3>

            <!-- Description (optionnelle) -->
            <p v-if="event.description" class="text-gray-600 text-sm xl:text-lg mb-4 line-clamp-2">
                {{ event.description }}
            </p>

            <!-- Informations date et lieu -->
            <div class="space-y-1">
                <div class="text-xs">
                    <span class="font-normal">Date :</span>
                </div>
                <div class="font-medium text-sm">
                    {{ formatDate(event.date) }}
                </div>
                <!-- <div class="text-sm text-gray-700">
                    <span class="font-normal">Lieu :</span>
                </div>
                <div class="text-base font-medium text-gray-800">
                    {{ event.location }}
                </div> -->
            </div>
        </div>
    </div>
</template>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>