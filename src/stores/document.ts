import { defineStore } from 'pinia'
import { getDecisions, getDocumentation, getLois } from '@/requests/document'
import type { IDocument, IDocumentRequest, IListDocumentResponse } from '@/requests/document'

export const useDocumentStore = defineStore('documentStore', {
  state: () => ({
    documents: [] as IDocument[],
    decisions: [] as IDocument[],
    lois: [] as IDocument[],

    pagination: {
      page: 1,
      pageSize: 10,
      pageCount: 0,
      total: 0,
    },
    opinionsPagination: {
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
    async fetchDocuments(request: IDocumentRequest) {
      this.loading = true
      this.error = null

      try {
        let response: IListDocumentResponse
        response = await getDocumentation(request)
        this.documents = response.data
        this.pagination = {
          page: response.current_page,
          pageSize: response.per_page,
          pageCount: response.last_page,
          total: response.total,
        }
        // eslint-disable-next-line @typescript-eslint/no-explicit-any
      } catch (err: any) {
        this.error = err.message || 'An error occurred while fetching documents.'
      } finally {
        this.loading = false
      }
    },

    async fetchDecisions(request: IDocumentRequest) {
      this.loading = true
      this.error = null

      try {
        let response: IListDocumentResponse
        response = await getDecisions(request)
        this.decisions = response.data
        this.pagination = {
          page: response.current_page,
          pageSize: response.per_page,
          pageCount: response.last_page,
          total: response.total,
        }
        // eslint-disable-next-line @typescript-eslint/no-explicit-any
      } catch (err: any) {
        this.error = err.message || 'An error occurred while fetching documents.'
      } finally {
        this.loading = false
      }
    },

        async fetchLois(request: IDocumentRequest) {
      this.loading = true
      this.error = null

      try {
        let response: IListDocumentResponse
        response = await getLois(request)
        this.lois = response.data
        this.pagination = {
          page: response.current_page,
          pageSize: response.per_page,
          pageCount: response.last_page,
          total: response.total,
        }
        // eslint-disable-next-line @typescript-eslint/no-explicit-any
      } catch (err: any) {
        this.error = err.message || 'An error occurred while fetching documents.'
      } finally {
        this.loading = false
      }
    },

    resetStore() {
      this.documents = []
      this.decisions = []
      this.lois = []
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
