import { defineStore } from 'pinia'

import {
  listMembers,
  type TListMembersRequest,
  type TListMembersResponse,
  type TMember,
} from '@/requests/member'

export const useMemberStore = defineStore('memberStore', {
  state: () => ({
    members: [] as TMember[], // List of documents
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
    async listMembers(request: TListMembersRequest) {
      this.loading = true
      this.error = null

      try {
        const response: TListMembersResponse = await listMembers(request)

        this.members = response.data
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
      this.members = []
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
