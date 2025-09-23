import { defineStore } from 'pinia'

import { listFaqs, type TListFaqsRequest, type TListFaqsResponse, type TFaq } from '@/requests/faq'

export const useFaqStore = defineStore('faqStore', {
  state: () => ({
    faqs: [] as TFaq[], // List of documents
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
    // Fetch documents from the API
    async listFaqs(request: TListFaqsRequest) {
      this.loading = true
      this.error = null

      try {
        const response: TListFaqsResponse = await listFaqs(request)

        this.faqs = response.data
        this.pagination = {
          page: response.current_page,
          pageSize: response.per_page,
          pageCount: response.last_page,
          total: response.total,
        }
        // eslint-disable-next-line @typescript-eslint/no-explicit-any
      } catch (err: any) {
        this.error = err.message || 'An error occurred while fetching faqs.'
      } finally {
        this.loading = false
      }
    },

    resetStore() {
      this.faqs = []
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
