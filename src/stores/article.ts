import { defineStore } from 'pinia'
import {
  listArticles,
  listArchives,
  getArticle,
  type TListArticlesRequest,
  type TListArticlesResponse,
  type TArticle,
  type TGetArticleResponse,
} from '@/requests/article'

export const useArticleStore = defineStore('articleStore', {
  state: () => ({
    articles: [] as TArticle[], // List of articles
    archives: [] as TArticle[], // List of articles
    article: null as TGetArticleResponse | null,
    pagination: {
      page: 1,
      pageSize: 10,
      pageCount: 0,
      total: 0,
    },
    loading: false,
    error: null as string | null,
  }),

  getters: {
    getArticles: (state) => {
      return state.articles
    },
    getArticle: (state) => {
      return state.article
    },
  },

  actions: {
    // Fetch articles from the API
    async listArticles(request: TListArticlesRequest) {
      this.loading = true
      this.error = null

      try {
        const response: TListArticlesResponse = await listArticles(request)
        this.articles = response.data
        this.pagination = {
          page: response.current_page,
          pageSize: response.per_page,
          pageCount: response.last_page,
          total: response.total,
        }
        // eslint-disable-next-line @typescript-eslint/no-explicit-any
      } catch (err: any) {
        this.error = err.message || 'An error occurred while fetching articles.'
      } finally {
        this.loading = false
      }
    },

    async listArchives(request: TListArticlesRequest) {
      this.loading = true
      this.error = null

      try {
        const response: TListArticlesResponse = await listArchives(request)

        this.archives = response.data
        this.pagination = {
          page: response.current_page,
          pageSize: response.per_page,
          pageCount: response.last_page,
          total: response.total,
        }
        // eslint-disable-next-line @typescript-eslint/no-explicit-any
      } catch (err: any) {
        this.error = err.message || 'An error occurred while fetching archives.'
      } finally {
        this.loading = false
      }
    },

    async fetchArticle(slug: string) {
      this.loading = true
      this.error = null

      try {
        const response = await getArticle({ slug })
        this.article = response
        // eslint-disable-next-line @typescript-eslint/no-explicit-any
      } catch (err: any) {
        this.error = err.message || 'An error occurred while fetching article.'
      } finally {
        this.loading = false
      }
    },

    resetStore() {
      this.articles = []
      this.article = null
      this.pagination = {
        page: 1,
        pageSize: 10,
        pageCount: 0,
        total: 0,
      }
      this.loading = false
      this.error = null
    },
  },
})
