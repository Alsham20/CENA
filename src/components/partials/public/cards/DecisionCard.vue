<!-- DecisionCard.vue -->
<template>
  <div class="w-full h-full bg-white shadow-xl transition-all duration-300 flex flex-col justify-between">
    <!-- En-tête de la carte -->
    <div class="p-4 border-t-4 border-t-[#2D3748] border-b border-gray-200 flex items-center gap-4">
      <div class="text-2xl xl:text-4xl">📄</div>
      <h3 class="text-[#2D3748] text-xl xl:text-3xl font-bold">{{ decision.number }}</h3>
    </div>

    <!-- Contenu de la carte -->
    <div class="p-4 flex-1 flex flex-col justify-between">
      <div>
        <p class="text-[#2D3748] font-bold text-xs xl:text-lg mb-3">
          Date : {{ formatDate(decision.date) }}
        </p>
        <p class="text-gray-700 text-sm xl:text-lg leading-relaxed">
          <span class="text-[#2D3748] font-bold">Objet : </span>
          {{ decision.object.slice(0, 100) }}
          {{ decision.object.length > 100 ? '...' : '' }}
        </p>
      </div>
    </div>

    <!-- Actions -->
    <div class="flex px-4 pb-6 gap-3 text-xs xl:text-lg font-semibold mt-auto">
      <button
        class="flex items-center justify-center gap-1 bg-[#2D3748] hover:bg-white text-white hover:text-[#2D3748] p-2 px-4 border-b border-[#2D3748] hover:border ease-in duration-300"
        @click="$emit('read', decision)">
        Lire
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
          class="bi bi-bookmark-fill w-3 h-3" viewBox="0 0 16 16">
          <path
            d="M2 2v13.5a.5.5 0 0 0 .74.439L8 13.069l5.26 2.87A.5.5 0 0 0 14 15.5V2a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2" />
        </svg>
      </button>
      <button
        class="flex items-center justify-center gap-1 p-2 px-4 border-b border-white text-white hover:text-[#0E6258] bg-[#0E6258] hover:bg-white hover:border-[#0E6258] ease-in duration-300"
        @click="$emit('download', decision)">
        Télécharger le PDF
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
          class="bi bi-download w-3 h-3" viewBox="0 0 16 16">
          <path
            d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5" />
          <path
            d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z" />
        </svg>
      </button>
    </div>
  </div>
</template>


<script setup lang="ts">
import type { DecisionType } from '@/types/decision'


interface Props {
  decision: DecisionType
}

interface Emits {
  read: [decision: DecisionType]
  download: [decision: DecisionType]
}

defineProps<Props>()
defineEmits<Emits>()

const formatDate = (date: Date): string => {
  return date.toLocaleDateString('fr-FR', {
    day: '2-digit',
    month: 'long',
    year: 'numeric'
  })
}
</script>