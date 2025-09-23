
<template>
  <div class="overflow-hidden shadow-2xl group border-s-2 border-[#11845a] bg-white pb-3 flex flex-col justify-between h-full">
    <!-- Image -->
    <img :src="
        article.image?.base_url + (article.image?.path || '') + '/' + (article.image?.name || '')
      " alt="" class="h-48 object-cover" />

    <!-- Contenu -->
    <div class="flex-1 flex flex-col justify-between mt-4 xl:mt-6 px-4 xl:px-6 space-y-4 xl:space-y-6">
      <!-- Meta -->
      <div class="space-y-2 xl:space-y-4">
        <div class="text-[#11845a] text-xs xl:text-md font-semibold flex">
          {{ article.categories?.label }} | {{ formatDate(article.created_at) }}
        </div>
        <h2 class="text-[#2c2c2c] font-medium text-sm xl:text-lg text-wrap mt-2">
          {{ article.title.slice(0, 100) }}
          {{ article.title.length > 100 ? '...' : '' }}
        </h2>
      </div>

      <!-- Bouton en bas -->
      <div class="flex justify-start mt-auto">
        <button 
          @click="$emit('read', article)"
          class="flex items-center bg-[#2D3748] rounded-sm text-white hover:text-white px-4 py-1 text-sm  xl:text-lg font-semibold space-x-1 ease-in duration-300"
        >
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
import type { ArticleType } from '@/types/article';

interface Props {
    article: TArticle
}

interface Emits {
    read: [article: TArticle]
}

defineProps<Props>()
defineEmits<Emits>()

const formatDate = (date: string) => {
    return new Date(date).toLocaleDateString('fr-FR', {
        day: 'numeric',
        month: 'long',
        year: 'numeric',
    })
}
</script>