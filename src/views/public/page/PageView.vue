<template>
  <div class="history bg-white flex flex-col space-y-6">
    <TitleComponent :title="page?.title || ''" />
    <div class="content px-6 lg:px-20 py-4 flex flex-col space-y-8">
      <div>
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
  name: 'historiesView',
  components: { TitleComponent
   },
  created() {
    this.$watch(
      () => this.$route.params.slug,
      (newSlug) => {
        this.store.fetchPage(newSlug as string)
      },
    )
  },
  data() {
    return {
      store: usePageStore(),
    }
  },
  mounted() {
    const { slug } = this.$route.params
    this.store.fetchPage(slug as string)
  },
  computed: {
    page() {
      return this.store.page
    },
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
</style>
