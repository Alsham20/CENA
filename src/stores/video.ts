import { defineStore } from 'pinia'
import {
  listVideos,
  type TListVideosRequest,
  type TListVideosResponse,
  type TVideo,
  type TGetVideoResponse,
} from '@/requests/video'

export const useVideoStore = defineStore('videoStore', {
  state: () => ({
    videos: [] as TVideo[], // List of videos
    video: null as TGetVideoResponse | null,
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
    getVideos: (state) => {
      return state.videos
    },
    getVideo: (state) => {
      return state.video
    },
  },

  actions: {
    // Fetch videos from the API
    async listVideos(request: TListVideosRequest) {
      this.loading = true
      this.error = null

      try {
        const response: TListVideosResponse = await listVideos(request)
        this.videos = response.data
        this.pagination = {
          page: response.current_page,
          pageSize: response.per_page,
          pageCount: response.last_page,
          total: response.total,
        }
        // eslint-disable-next-line @typescript-eslint/no-explicit-any
      } catch (err: any) {
        this.error = err.message || 'An error occurred while fetching videos.'
      } finally {
        this.loading = false
      }
    },

    resetStore() {
      this.videos = []
      this.video = null
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
