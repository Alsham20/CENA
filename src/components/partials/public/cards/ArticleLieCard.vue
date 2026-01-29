<template>
  <div
    class="overflow-hidden shadow-sm group border-s hover:bg-[#11845a] border-[#11845a] bg-white p-3 py-4 space-y-4"
  >
    <div class="space-y-4">
      <div class="text-[#11845a] text-lg font-semibold group-hover:text-white">
        {{ article?.categories?.label }} | {{ formatDate(article.created_at.toString()) }}
      </div>
      <div
        class="preserve-content text-black font-semibold text-[16px] pe-6 text-wrap group-hover:text-white"
        v-html="article.title.slice(0, 70) + (article.title.length > 70 ? '...' : '')"
      ></div>
      <div class="flex justify-start">
        <button
          @click="readArticle()"
          class="mb-3 inline-block border-black group-hover:border-[#FFBE00] group-hover:bg-white border-b-2 hover:!bg-[#11845a] text-black hover:text-white px-2 py-1 text-lg font-semibold ease-in duration-300"
        >
          Lire l'article
        </button>
      </div>
    </div>
  </div>
</template>
<script lang="ts">
import type { TArticle } from '@/requests/article'
import type { PropType } from 'vue'
import { useRouter } from 'vue-router'

export default {
  data() {
    return {
      router: useRouter(),
    }
  },
  props: {
    article: {
      type: Object as PropType<TArticle>,
      required: true,
    },
  },
  methods: {
    readArticle() {
      this.router.push('/articles/' + this.article.slug)
    },
    formatDate(date: string) {
      return new Date(date).toLocaleDateString('fr-FR', {
        day: 'numeric',
        month: 'long',
        year: 'numeric',
      })
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
