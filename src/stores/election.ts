import { defineStore } from 'pinia'

import {
  listElections,
  type TListElectionsRequest,
  type TListElectionsResponse,
  type TElection,
} from '@/requests/election'

export const useElectionStore = defineStore('electionStore', {
  state: () => ({
    elections: [] as TElection[], // List of documents
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
    async listElections(request: TListElectionsRequest) {
      this.loading = true
      this.error = null

      try {
        const response: TListElectionsResponse = await listElections(request)

        this.elections = response.data
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
      this.elections = []
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
