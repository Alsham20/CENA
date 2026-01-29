<template>
  <div
    class="relative overflow-hidden shadow-2xl group border-s-2 border-[#11845a] bg-white pb-3 flex flex-col justify-between h-full">
    <!-- Image -->
         <img
      src="/src/assets/img/images-removebg-preview.png"
      alt="Loading"
      class="h-48 object-contain"
      :class="{ hidden: imageLoaded && !imageError }"
    />


    <img :src="article.image?.base_url + (article.image?.path || '') + '/' + (article.image?.name || '')
      " alt="" class="h-48 object-cover" 
            :class="{ hidden: imageError }"
      @load="onImageLoad()"
      @error="onImageError()"/>
    <!-- Badge de catégorie -->
    <div class="absolute top-3 right-3 px-3 py-1 bg-[#2D3748] text-white text-xs xl:text-lg font-medium rounded">
      {{ article.categories?.label }}
    </div>

    <!-- Contenu -->
    <div class="flex-1 flex flex-col justify-between mt-4 xl:mt-6 px-4 xl:px-6 space-y-4 xl:space-y-6">
      <!-- Meta -->
      <div class="space-y-2 xl:space-y-4">
        <div class="flex text-sm xl:text-md gap-2">
          <span class="text-[#11845a] font-semibold">{{ article.activities?.label }}</span>
          |
          <span class="text-[#2C2C2C] font-normal"> {{ formatDate(article.created_at) }}</span>
        </div>
        <h2 class="text-[#2c2c2c] font-medium text-sm xl:text-lg text-wrap mt-2">
          {{ article.title.slice(0, 100) }}
          {{ article.title.length > 100 ? '...' : '' }}
        </h2>
      </div>

      <!-- Bouton en bas -->
      <div class="flex justify-start mt-auto">
        <button @click="$emit('read', article)"
          class="flex items-center bg-[#0E6258] rounded-sm text-white hover:text-white px-4 py-1 text-sm  xl:text-lg font-semibold space-x-1 ease-in duration-300">
          <span class="font-semibold">Lire l'article</span>
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5l6 6m0 0l-6 6m6-6H4.5" />
          </svg>
        </button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import type { TArticle } from '@/requests/article';
import { ref } from 'vue';

interface Props {
  article: TArticle
}

interface Emits {
  read: [article: TArticle]
}

defineProps<Props>()
defineEmits<Emits>()

const imageLoaded = ref<boolean>(false)

const imageError = ref<boolean>(false)

const onImageLoad = () => {
  imageLoaded.value = true
  imageError.value = false
}

const onImageError = () => {
  imageError.value = true
  imageLoaded.value = false
}

const formatDate = (date: string) => {
  return new Date(date).toLocaleDateString('fr-FR', {
    day: 'numeric',
    month: 'long',
    year: 'numeric',
  })
}
</script>