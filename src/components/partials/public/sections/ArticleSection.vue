<script setup lang="ts">
import { articles } from '@/data';
import ArticleCard from '../cards/ArticleCard.vue';
import type { ArticleType } from '@/types/article';

    const handleRead = (article: ArticleType) => {
      console.log('Article à lire:', article.title)
    }

</script>

<template>
  <div class="py-4 md:py-8 m-auto w-[90%] space-y-4 md:space-y-10" >
    <div class="flex justify-between items-center">
      <h1 class="text-[#0E6258] text-xl md:text-3xl xl:text-5xl font-extrabold">Dernières actualités</h1>
      <div class="flex items-center space-x-4 text-center">
        <span class="text-[#11845a] text-sm xl:text-xl font-medium invisible md:visible">TOUTES LES ACTUALITÉS</span>
        <button class="p-2 xl:p-4 rounded-full bg-[#11845a] text-white">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 xl:h-8 xl:w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 4.5c-4.99 0-9.27 3.11-11 7.5 1.73 4.39 6.01 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6.01-7.5-11-7.5z" />
            <circle cx="12" cy="12" r="3" stroke-width="2" />
          </svg>
        </button>
      </div>
    </div>
    <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-8" data-aos="fade-up"
     data-aos-duration="1000">
        <ArticleCard v-for="article in articles.slice(0,3)" :key="article.id" :article="article" @read="handleRead"/>
    </div>
  </div>
</template>