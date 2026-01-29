import { defineStore } from 'pinia'
import {
  listEvents,
  getEvent,
  type TListEventsRequest,
  type TListEventsResponse,
  type TEvent,
  type TGetEventResponse,
} from '@/requests/event'

export const useEventStore = defineStore('eventStore', {
  state: () => ({
    events: [] as TEvent[], // List of events
    event: null as TGetEventResponse | null,
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
    getEvents: (state) => {
      return state.events
    },
    getEvent: (state) => {
      return state.event
    },
  },

  actions: {
    // Fetch events from the API
    async listEvents(request: TListEventsRequest) {
      this.loading = true
      this.error = null

      try {
        const response: TListEventsResponse = await listEvents(request)
        this.events = response.data
        this.pagination = {
          page: response.current_page,
          pageSize: response.per_page,
          pageCount: response.last_page,
          total: response.total,
        }
        // eslint-disable-next-line @typescript-eslint/no-explicit-any
      } catch (err: any) {
        this.error = err.message || 'An error occurred while fetching events.'
      } finally {
        this.loading = false
      }
    },

    async fetchEvent(slug: string) {
      this.loading = true
      this.error = null

      try {
        const response = await getEvent({ slug })
        this.event = response
        // eslint-disable-next-line @typescript-eslint/no-explicit-any
      } catch (err: any) {
        this.error = err.message || 'An error occurred while fetching event.'
      } finally {
        this.loading = false
      }
    },

    resetStore() {
      this.events = []
      this.event = null
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
