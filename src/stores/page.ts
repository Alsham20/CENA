import { getPage, listPages, type TGetPageResponse, type TListPagesRequest } from '@/requests/page'
import { defineStore } from 'pinia'

export const usePageStore = defineStore('pageStore', {
  state: () => ({
    page: null as TGetPageResponse | null,
    pages: [] as TGetPageResponse[],
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
    async fetchPages(request: TListPagesRequest) {
      this.loading = true
      this.error = null

      try {
        const response = await listPages(request)
        this.pages = response.data
        this.pagination = {
          page: response.current_page,
          pageSize: response.per_page,
          pageCount: response.last_page,
          total: response.total,
        }
        // eslint-disable-next-line @typescript-eslint/no-explicit-any
      } catch (err: any) {
        // console.log(err)
        this.error = err.message || 'An error occurred while fetching pages.'
      } finally {
        this.loading = false
      }
    },
    async fetchPage(slug: string) {
      this.loading = true
      this.error = null

      try {
        const response = await getPage({ slug })
        this.page = response
        // eslint-disable-next-line @typescript-eslint/no-explicit-any
      } catch (err: any) {
        //console.log(err)
        this.error = err.message || 'An error occurred while fetching page.'
        this.page = null
      } finally {
        this.loading = false
      }
    },
  },
})
