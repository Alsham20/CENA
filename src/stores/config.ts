import { defineStore } from 'pinia'

import { listConfigs, type TListConfigsResponse, type TConfig } from '@/requests/config'

export const useConfigStore = defineStore('configStore', {
  state: () => ({
    configs: [] as TConfig[], // List of documents
    loading: false,
    error: null as string | null,
  }),

  actions: {
    // Fetch documents from the API
    async listConfigs() {
      this.loading = true
      this.error = null

      try {
        const response: TListConfigsResponse = await listConfigs()

        this.configs = response

        // eslint-disable-next-line @typescript-eslint/no-explicit-any
      } catch (err: any) {
        this.error = err.message || 'An error occurred while fetching configs.'
      } finally {
        this.loading = false
      }
    },
    getConfig(key: string): TConfig | null {
      const response: TConfig | undefined = this.configs.find((config) => config.key === key)
      if (!response) {
        return null
      }
      return response
    },

    resetStore() {
      this.configs = []
      this.loading = false
      this.error = null
    },
  },
})
