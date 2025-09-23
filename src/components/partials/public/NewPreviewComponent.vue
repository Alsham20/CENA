<template>
  <div class="overflow-hidden shadow-2xl group border-s-2 border-[#11845a] bg-white pb-3 space-y-4">
    <img :src="article.imageUrl" :alt="article.title" class="w-full h-40 object-cover" />
    <div class="space-y-4 px-3">
      <div class="text-[#11845a] text-xs font-semibold flex">
        Comptes rendus | {{ formatDate(article.date.toString()) }}
      </div>
      <h2 class="text-slate-800 font-medium text-sm text-wrap">
        {{ article.title }}
      </h2>
      <div class="flex justify-start">
        <router-link to=""
          class="flex items-center  bg-[#2D3748] rounded-sm text-white hover:text-white px-2 py-1 text-sm font-semibold space-x-1 ease-in duration-300">
          <span class="font-semibold">Lire l'article</span>
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5l6 6m0 0l-6 6m6-6H4.5" />
          </svg>
        </router-link>
      </div>
    </div>
  </div>
</template>
<script setup lang="ts">
import type { ArticleType } from '@/types/article';

interface Props {
  article: ArticleType
}

interface Emits {
  read: [article: ArticleType]
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