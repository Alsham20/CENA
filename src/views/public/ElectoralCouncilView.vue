<template>
  <div class="history bg-white flex flex-col space-y-6">
    <TitleComponent :title="page?.title || ''" />
    <div class="content px-6 lg:px-16 py-4 flex flex-col space-y-8">
      <div v-if="loading" class="flex justify-center items-center py-8">
        <div class="loader"></div>
      </div>
      <div v-else>
        <div class="preserve-content" v-html="page?.content"></div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import TitleComponent from '@/components/common/TitleComponent.vue';
import { useSeo } from '@/composables/useSeo'
import { usePageStore } from '@/stores/page'
export default {
  name: 'ElectoralCouncilView',
  components: { TitleComponent },
  data() {
    return {
      store: usePageStore(),
    }
  },
  mounted() {
    this.store.fetchPage('conseil-electoral')
  },
  computed: {
    page() {
      return this.store.page
    },

    loading() {
      return this.store.loading
    }
  },

  watch: {
    page: {
      handler(page) {
        if (page) {
          useSeo(page);
        }
      },
      immediate: true, // Exécute immédiatement au montage du composant
    },
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
