<script lang="ts" setup>
import FlashInfoBanner from '@/components/partials/public/FlashInfoBanner.vue';
import ArticleSection from '@/components/partials/public/sections/ArticleSection.vue';
import DecisionsSection from '@/components/partials/public/sections/DecisionsSection.vue';
import EventSection from '@/components/partials/public/sections/EventSection.vue';
import ExecutiveBoardSection from '@/components/partials/public/sections/ExecutiveBoardSection.vue';
import GallerySection from '@/components/partials/public/sections/GallerySection.vue';
import SlidesSection from '@/components/partials/public/sections/SlidesSection.vue';
import VideoSection from '@/components/partials/public/sections/VideoSection.vue';
import ServiceCardComponent from '@/components/partials/public/ServiceCardComponent.vue';
import { services } from '@/data';
import { useArticleStore } from '@/stores/article';
import { onMounted, computed } from 'vue';

const articleStore = useArticleStore()
const articles = computed(() => articleStore.articles)
const servicesData = services;

onMounted(() => {
  articleStore.listArticles({
    page: 1,
    pageSize: 20,
    orderBy: 'date_article',
    orderDirection: 'desc',
  })
})


</script>

<template>

  <div class="pt-2 md:pt-4 px-2 md:px-4">
    <!-- Flash Info Component -->
    <div v-if="articles.length > 0">
      <FlashInfoBanner :infos="articles.slice(0, 3)" />

    </div>
  </div>
  <div class="p-2 md:p-4" data-aos="zoom-in" data-aos-duration="1000">
    <!-- Slider-->
    <SlidesSection />
  </div>
  <!-- Mot du président-->

  <!-- <div class="president-word mx-auto w-full max-w-[1200px] bg-[#ddf1ee] py-4 md:py-12  md:space-y-10 space-y-4">
    <div class="m-auto w-[90%]">
      <h1 class="text-[#0E6258] text-xl md:text-[39px] font-extrabold">Le mot du président</h1>
    </div>
    <div class="m-auto w-[90%]">
      <div class="md:flex space-y-6 space-x-0 md:space-x-32 md:space-y-0 text-black font-[800]">
        <div class="president-word-image md:shrink-0 space-y-4">
          <img src="@/assets/img/home/president-word-image.jpg" alt="president" class="object-cover w-full" />
          <div>
            <p class="text-center text-[24px]">
              <span class="font-bold text-[25px]">
                SACCA Lafia
              </span>
              <br />
              PRÉSIDENT du Conseil Électoral
            </p>
          </div>
        </div>
        <div
          class="president-word-content relative text-[16px] xl:text-[20px] font-[400] leading-normal bg-[#c5d6d3] p-6">
          <div class="preserve-content">
            <p class="font-medium text-justify">
              Chers compatriotes,
            </p>
            <p class="font-medium text-justify">
              Chers citoyens électeurs,
            </p>
            <p class="font-medium text-justify">
              Aux partenaires techniques et financiers des élections,
            </p>
            <p class="font-medium text-justify">
              A toutes les parties prenantes,
            </p>
            <p class="font-medium text-justify">
              A vous tous qui visitez ce site web de la CENA.
            </p>
            <p class="font-medium text-justify">
              Je vous souhaite à la bienvenue sur cette vitrine du processus électoral Béninois. Je suis convaincu que,
              comme nous, vous aspirez à un processus démocratique fiable qui aboutira à des élections apaisées, libres,
              transparentes et dont les résultats seront bénéfiques pour notre pays le Bénin.
            </p>
          </div>

          <div class="flex flex-row justify-end">
            <router-link to="/mot-du-president"
              class="flex mt-4 md:mt-0 bottom-0 right-0 py-4 px-6 space-x-2 text-white text-lg md:text-md bg-[#EC0001] ease-in duration-300">
              <span class="font-semibold">En savoir plus</span>
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m-8-8h16" />
              </svg>
            </router-link>
          </div>
        </div>
      </div>
    </div>
  </div> -->
  <div class="mx-auto max-w-full bg-white">
    <ArticleSection />
  </div>

  <div class="bg-[#c5d6d3 mx-auto max-w-full">
    <VideoSection/>
  </div>
  <!-- <div class="bg-[#729FE01A] mx-auto max-w-[1200px]">
    <div class="py-4 md:py-8 space-y-4 md:space-y-6 m-auto w-[90%]">
      <div class="flex justify-between items-center">
        <h1 class="text-[#0E6258] text-xl md:text-3xl font-extrabold uppercase">Décisions récentes</h1>
        <div class="flex items-center space-x-2 text-center">
          <span class="text-black md:text-lg font-medium invisible md:visible">Voir tous</span>
          <router-link to="/documents" class="p-2 rounded-full hover:bg-[#EC0001] bg-[#EC0001] text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 4.5c-4.99 0-9.27 3.11-11 7.5 1.73 4.39 6.01 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6.01-7.5-11-7.5z" />
              <circle cx="12" cy="12" r="3" stroke-width="2" />
            </svg>
          </router-link>
        </div>
      </div>
      <div class="grid md:grid-cols-2 gap-6">
        <div v-for="resource in resourcesData" :key="resource.id">
          <ResourcePreviewComponent v-bind="resource" />
        </div>
      </div>
    </div>
    <div class="bg-[#ebfaeb] md:px-14 py-4 md:py-8 grid grid-cols-1 gap-6">
        <div class="text-[#0E6258] text-xl md:text-3xl font-extrabold">Liens connexes
        </div>
        <div v-for="service in servicesData" :key="service.id">
          <ServiceCardComponent :service="service" />
        </div>
      </div> 
  </div> -->

  <div class="bg-[#729FE01A] mx-auto max-w-full">
    <DecisionsSection />
  </div>

  <div class="bg-[#c5d6d3] mx-auto max-w-full">
    <EventSection />
  </div>

  <div class="mx-auto max-w-full bg-white">
    <GallerySection />
  </div>

  <div class="bg-[#ebfaeb] mx-auto max-w-full">
    <div class="py-4 md:py-8 space-y-4 md:space-y-6 m-auto w-[90%]">
      <div class="text-[#0E6258] text-xl md:text-3xl xl:text-5xl font-extrabold">Liens utiles
      </div>
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <ServiceCardComponent v-for="service in servicesData" :key="service.id" :service="service" />
      </div>
    </div>
  </div>
  <div class="md:py-8 py-4 mx-auto max-w-full bg-gray-50">
    <ExecutiveBoardSection />
  </div>
</template>
<style scoped>
.preserve-content :deep(*) {
  all: revert;
}
</style>
<style>
.preserve-content dl,
.preserve-content ol,
.preserve-content ul {
  padding-left: 2rem !important;
  line-height: 1.8rem !important;
}

.preserve-content ul li {
  list-style: disc !important;
  line-height: 1.8rem !important;
}

.preserve-content ul {
  padding-top: 1rem !important;
}

.preserve-content p {
  margin-top: 0 !important;
  margin-bottom: 1rem !important;
  line-height: 1.8rem !important;
}
</style>
