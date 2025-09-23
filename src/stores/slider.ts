import { defineStore } from 'pinia'

import {
  listSliders,
  type TListSlidersRequest,
  type TListSlidersResponse,
  type TSlider,
} from '@/requests/slider'
import {
  listSliderArticles,
  type TArticle,
  type TListSliderArticlesResponse,
} from '@/requests/article'

export const useSliderStore = defineStore('sliderStore', {
  state: () => ({
    sliders: [] as TSlider[], // List of sliders
    sliderArticles: [] as TArticle[], // List of slider articles
    pagination: {
      page: 1,
      pageSize: 10,
      pageCount: 0,
      total: 0,
    },
    loading: false,
    error: null as string | null,
  }),

  actions: {
    // Fetch sliders from the API
    async listSliders(request: TListSlidersRequest) {
      this.loading = true
      this.error = null

      try {
        const response: TListSlidersResponse = await listSliders(request)

        this.sliders = response.data
        this.pagination = {
          page: response.current_page,
          pageSize: response.per_page,
          pageCount: response.last_page,
          total: response.total,
        }
        // eslint-disable-next-line @typescript-eslint/no-explicit-any
      } catch (err: any) {
        this.error = err.message || 'An error occurred while fetching sliders.'
      } finally {
        this.loading = false
      }
    },
    async listSliderArticles() {
      this.loading = true
      this.error = null

      try {
        const response: TListSliderArticlesResponse = await listSliderArticles()
        this.sliderArticles = response
        // eslint-disable-next-line @typescript-eslint/no-explicit-any
      } catch (err: any) {
        this.error = err.message || 'An error occurred while fetching slider articles.'
      } finally {
        this.loading = false
      }
    },

    resetStore() {
      this.sliders = []
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
