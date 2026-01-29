<template>
    <div class="flex flex-col space-y-8 bg-slate-100">
        <TitleComponent title="Actualités" />

        <div class="content px-6 md:px-16 py-6 md:py-8 flex flex-col space-y-8">
            <div v-if="isLoading" class="flex justify-center items-center py-8">
                <div class="loader"></div>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-10">
                <div v-for="article in articles" :key="article.id" data-aos="fade-up" data-aos-duration="1000"
                    data-aos-once="true">
                    <ArticleCard :article="article" @read="handleRead"/>
                </div>
            </div>
            <div class="flex justify-center col-span-full">
                            <PaginationComponent :current-page="pagination.page" :total-items="pagination.total"
                                :items-per-page="12" :max-visible-pages="5" @page-change="changePage" />
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import { useArticleStore } from '@/stores/article'
import { computed, onMounted } from 'vue'
import ArticleCard from '@/components/partials/public/cards/ArticleCard.vue'
import TitleComponent from '@/components/common/TitleComponent.vue'
import PaginationComponent from '@/components/partials/public/PaginationComponent.vue'
import { useRouter } from 'vue-router'
import type { TArticle } from '@/requests/article'

export default {
    name: 'ActualitesView',
    components: { TitleComponent, ArticleCard, PaginationComponent },

    setup() {
        const articleStore = useArticleStore()

        const router = useRouter();

        const handleRead = (article: TArticle) => {
            console.log(article.slug);
            router.push('/articles/' + article.slug)
        }

        // Fetch documents on component mount
        onMounted(() => {
            articleStore.listArticles({
                page: 1,
                pageSize: 12,
                orderBy: 'date_article',
                orderDirection: 'desc',
            })
        })

        // Computed properties for store state
        const articles = computed(() => articleStore.articles)
        const isLoading = computed(() => articleStore.loading)
        const pagination = computed(() => articleStore.pagination)

        const changePage = (page: number) => {
            articleStore.listArticles({
                page,
                pageSize: 12,
                orderBy: 'date_article',
                orderDirection: 'desc',
            })
        }

        return {
            articles,
            isLoading,
            pagination,
            changePage,
            handleRead,
        }
    },
}
</script>
<style scoped>
/* Styles pour le loader */
.loader {
    border: 4px solid #f3f3f3;
    /* Couleur de fond */
    border-top: 4px solid #11845a;
    /* Couleur principale */
    border-radius: 50%;
    width: 40px;
    height: 40px;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }

    100% {
        transform: rotate(360deg);
    }
}
</style>
