<template>
  <div class="bg-slate-100">
    <TitleComponent :title="pagePresident?.title ||'Président'" />
    <!-- Image -->
    <section class="py-16 bg-gradient-to-br from-gray-50 to-gray-100">
      <div v-if="isLoading" class="flex justify-center items-center py-8">
        <div class="loader"></div>
      </div>
      <div v-else class="container mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-8 items-start max-w-6xl mx-auto">
          <!-- Image du président -->
          <div class="lg:w-5/12 flex-shrink-0">
            <div class="relative rounded overflow-hidden shadow-2xl">
              <img :src="getMediaUrl(pagePresident?.poster_media) ||
                '/src/assets/img/images-removebg-preview.png'" alt="Président" class="w-full h-auto object-cover" />
              <!-- Gradient overlay subtil -->
              <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent"></div>
            </div>
          </div>

          <!-- Contenu texte -->
          <div class="lg:w-7/12 flex flex-col justify-center">
            <!-- Nom -->
            <h2 class="text-2xl md:text-4xl font-bold text-blue-900 mb-3">
              {{ configStore.getConfig('president_name')?.value }}
            </h2>

            <!-- Titre/Position -->
            <p class="text-xl md:text-xl text-[#11845a] font-semibold mb-8">
              {{ configStore.getConfig('president_title')?.value }}
            </p>

            <!-- Biographie -->
            <div v-if="pagePresident" class="bg-white shadow-lg p-8 space-y-6">
              <div class="preserve-content" v-html="pagePresident.content">
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script lang="ts">
import TitleComponent from '@/components/common/TitleComponent.vue';
import { usePageStore } from '@/stores/page'
import { computed, onMounted, watch } from 'vue'
import { useConfigStore } from '@/stores/config'
import { useSeo } from '@/composables/useSeo'
import { useMedia } from '@/composables/useMedia';
export default {
  name: 'PresidentView',
  components: { TitleComponent },
  setup() {
    const pageStore = usePageStore()
    const configStore = useConfigStore()
    const getMediaUrl = useMedia().getMediaUrl
    onMounted(async () => {
      await pageStore.fetchPage('president')
      await configStore.listConfigs()
    })

    watch(() => pageStore.page, (page) => {
      if (page) {
        useSeo(page);
      }
    }, { immediate: true });
    const pagePresident = computed(() => pageStore.page)
    const isLoading = computed(() => pageStore.loading)

    return { pagePresident, getMediaUrl, configStore, isLoading }
  },
}

</script>

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
