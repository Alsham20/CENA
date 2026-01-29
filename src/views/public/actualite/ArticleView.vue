<template>
    <div class="bg-slate-100">
        <TitleComponent title="Actualités" />
        <div v-if="isLoading" class="flex justify-center items-center py-8">
            <div class="loader"></div>
        </div>
        <div class="mx-auto px-4 md:px-16 py-8 space-y-10">
            <div class="flex flex-col-reverse md:flex-row gap-4 md:gap-10">
                <!-- Image -->
                <div class="w-full md:w-2/3">
                    <div class="relative overflow-hidden">
                        <img src="/src/assets/img/images-removebg-preview.png" alt="Loading"
                            class="w-full h-64 object-cover" :class="{ hidden: imageLoaded && !imageError }" />

                        <img :src="decodeURIComponent(getSrc())" alt=""
                            class="w-full h-auto object-cover object-[10%_60%]" :class="{ hidden: imageError }"
                            @load="onImageLoad()" @error="onImageError()" />
                    </div>
                </div>
                <!-- Contenu textuel -->
                <div class="w-full md:w-1/3 space-y-4 flex flex-col justify-center">
                    <div class="text-[#0E6258] font-semibold text-[16px]">
                        {{ getArticle()?.categories?.label }} |
                        {{ formatDate(getArticle()?.date_article || '') }}
                    </div>

                    <h1 class="text-lg md:text-xl lg:text-2xl font-semibold text-slate-800 mb-6">
                        {{ getArticle()?.title }}
                    </h1>

                    <div class="text-gray-600 space-x-4 text-xs">
                        <!-- <span class="uppercase font-semibold"
              >PUBLIÉ LE {{ formatDate(getArticle()?.created_at) }}</span
            >
            <span class="uppercase font-semibold">|</span> -->
                        <span class="uppercase font-semibold">
                            Lecture : {{ estimateReadingTime(getArticle()?.content || '') }} min</span>
                    </div>

                    <div class="flex gap-4">
                        <!-- Facebook -->
                        <a :href="`https://www.facebook.com/sharer/sharer.php?u=${articleUrl}`" target="_blank"
                            rel="noopener noreferrer" class="text-gray-600 hover:text-gray-900">
                            <img src="/src/assets/socials/facebook.svg" alt="Facebook" class="w-6 h-6" />
                        </a>

                        <!-- Twitter -->
                        <a :href="`https://twitter.com/intent/tweet?url=${articleUrl}&text=${encodeURIComponent(articleTitle)}`"
                            target="_blank" rel="noopener noreferrer" class="text-gray-600 hover:text-gray-900">
                            <img src="/src/assets/socials/twitter.svg" alt="Twitter" class="w-6 h-6" />
                        </a>

                        <!-- WhatsApp -->
                        <a :href="`https://wa.me/?text=${encodeURIComponent(articleTitle + ' ' + articleUrl)}`"
                            target="_blank" rel="noopener noreferrer" class="text-gray-600 hover:text-gray-900">
                            <img src="/src/assets/socials/whatsapp.svg" alt="WhatsApp" class="w-6 h-6" />
                        </a>
                    </div>
                </div>
            </div>
            <div v-if="getArticle() && getArticle()?.is_published !== 0 && getArticle()?.is_private === 0"
                class="flex flex-col md:flex-row gap-4 md:gap-10">
                <!-- Image -->
                <div class="w-full md:w-2/3 bg-white p-6">
                    <div class="preserve-content mx-auto text-black text-[16px] text-justify leading-tight space-y-4"
                        v-html="getArticle()?.resume"></div>
                    <div class="preserve-content mx-auto text-black text-[16px] text-justify leading-tight space-y-4"
                        v-html="getArticle()?.content"></div>
                </div>
                <!-- Contenu textuel -->
                <div v-if="getFilteredArticles().length > 0" class="w-full md:w-1/3 space-y-4 md:py-4 flex flex-col">
                    <div class="text-gray-700 space-x-4 font-semibold text-lg">Autres articles</div>
                    <div class="grid gap-6 md:px-4" v-if="getArticles()">
                        <div v-for="article in getFilteredArticles()" :key="article.id">
                            <ArticleLieCard :article="article" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script lang="ts">
import TitleComponent from '@/components/common/TitleComponent.vue'
import ArticleLieCard from '@/components/partials/public/cards/ArticleLieCard.vue'
import { useArticleSeo } from '@/composables/useSeo'
import { useArticleStore } from '@/stores/article'
import dayjs from 'dayjs'
export default {
    name: 'ArticleDetail',
    components: { TitleComponent, ArticleLieCard },
    data() {
        return {
            store: useArticleStore(),
            imageLoaded: false,
            imageError: false,
        }
    },

    methods: {
        getSrc() {
            const image = this.getArticle()?.image
            if (image) {
                return `${image.base_url}${image.path}/${image.name}`
            }
            return ''
        },
        getArticle() {
            return this.store.getArticle
        },
        getArticles() {
            return this.store.getArticles
        },

        countWords(text: string) {
            // Supprimer les balises HTML
            if (typeof text !== 'string') {
                // Si le texte n'est pas une chaîne, on retourne 0 mots
                return 0
            }
            const plainText = text.replace(/<[^>]+>/g, '')

            // Supprimer les espaces supplémentaires et diviser le texte en mots
            const words = plainText.trim().split(/\s+/)
            return words.length
        },
        estimateReadingTime(text: string, wordsPerMinute = 200) {
            const wordCount = this.countWords(text)
            const readingTimeMinutes = wordCount / wordsPerMinute

            // On arrondit à la minute supérieure pour une meilleure estimation
            return Math.ceil(readingTimeMinutes)
        },
        formatDate(date: string) {
            if (date) {
                return dayjs(date).format('DD-MM-YYYY')
            }
            return ''
        },
        getFilteredArticles() {
            const articles = this.getArticles() || []
            return articles
                .filter(
                    (article) =>
                        article.slug !== this.$route.params.id &&
                        article.is_published === 1 &&
                        article.is_private === 0,
                )
                .slice(0, 3)
        },
        showArticle() {
            this.store.fetchArticle(this.$route.params.id as string)
        },
        trigger404() {
            this.$router.push({ name: 'NotFound' })
        },
        checkArticlePublished() {
            const article = this.getArticle()
            if (article && article.is_published === 0) {
                this.trigger404()
            }
        },
        onImageLoad() {
            this.imageLoaded = true
            this.imageError = false
        },
        onImageError() {
            this.imageError = true
            this.imageLoaded = false
        },
    },

    mounted() {
        this.store.fetchArticle(this.$route.params.id as string)
        this.store.listArticles({
            page: 1,
            pageSize: 20,
        })
    },
    watch: {
        '$route.params.id': 'showArticle',

        article: {
            handler(article) {
                if (article) {
                    useArticleSeo(article);

                }
            },
            immediate: true, // Exécute immédiatement au montage du composant
        },
    },
    computed: {
        article() {
            return this.store.article
        },
        articleUrl() {
            return `${window.location.origin}/actualites/${this.getArticle()?.slug || this.getArticle()?.id}`
        },

        articleTitle() {
            return this.getArticle()?.title || 'Un super article' // Titre par défaut
        },

        isLoading() {
            return this.store.loading
        },
    },
}
</script>
<style>
/* Styles pour le loader */
.loader {
    border: 4px solid #f3f3f3;
    /* Couleur de fond */
    border-top: 4px solid #0E6258;
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
