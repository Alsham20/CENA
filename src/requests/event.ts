import { z } from 'zod'
import { paginationRequestSchema, paginationResponseSchema } from './utils'
import apiClient from '@/utils/api'
export const mediaSchema = z.object({
  id: z.number(),
  base_url: z.string(),
  path: z.string(),
  name: z.string(),
  thumbnail: z.string(),
  type: z.string(),
  size: z.string(),
  author_id: z.number(),
  created_at: z.string(),
  updated_at: z.string().nullable(),
})

export const categorySchema = z.object({
  id: z.number(),
  author: z.number(),
  parent: z.number().nullable(),
  label: z.string(),
  type: z.string(),
  created_at: z.string().nullable(),
  updated_at: z.string().nullable(),
})

export const eventSchema = z.object({
  id: z.number(),
  event_name: z.string(),
  place: z.string(),
  slug: z.string().nullable(),
  poster: z.number().nullable(),
  event_description: z.string().nullable(),
  event_date: z.string().nullable().optional(),
  event_start: z.string().nullable().optional(),
  event_end: z.string().nullable().optional(),
  is_published: z.number(),
  categories: categorySchema.nullable(),
  created_at: z.string(),
  updated_at: z.string().nullable(),
  image: mediaSchema.nullable(),
})

export type TEvent = z.infer<typeof eventSchema>

export const listEventsRequestSchema = paginationRequestSchema.extend({
  searchQuery: z.string().optional(),
})

export type TListEventsRequest = z.infer<typeof listEventsRequestSchema>

export const listEventsResponseSchema = paginationResponseSchema.extend({
  data: z.array(eventSchema),
})

export const listSliderEventsResponseSchema = z.array(eventSchema)

export type TListEventsResponse = z.infer<typeof listEventsResponseSchema>
export type TListSliderEventsResponse = z.infer<typeof listSliderEventsResponseSchema>
export const getEventRequestSchema = z.object({
  slug: z.string(),
})
export type TGetEventRequest = z.infer<typeof getEventRequestSchema>
export const getEventResponseSchema = eventSchema
export type TGetEventResponse = z.infer<typeof getEventResponseSchema>

export const listEvents = async (
  payload: TListEventsRequest,
): Promise<TListEventsResponse> => {
  try {
    const response = await apiClient.get(`/events`, { params: payload })
    if (response.status !== 200) {
      throw new Error('Unable to fetch event. Please try again later.')
    }
    if (!listEventsResponseSchema.safeParse(response.data).success) {
      //console.log(listEventsResponseSchema.safeParse(response.data).error)
      throw new Error('Unable to parse event. Please try again later.')
    }
    return listEventsResponseSchema.parse(response.data)
  } catch (error) {
    console.error('Failed to fetch event:', error)
    throw new Error('Unable to fetch event. Please try again later.')
  }
}

export const getEvent = async (payload: TGetEventRequest): Promise<TGetEventResponse> => {
  try {
    const response = await apiClient.get(`/events/${payload.slug}/show`)
    if (response.status !== 200) {
      throw new Error('Unable to fetch event. Please try again later.')
    }
    if (!getEventResponseSchema.safeParse(response.data).success) {
      //console.log(getEventResponseSchema.safeParse(response.data).error)
      throw new Error('Unable to parse event. Please try again later.')
    }
    return getEventResponseSchema.parse(response.data)
  } catch (error) {
    console.error('Failed to fetch event:', error)
    throw new Error('Unable to fetch event. Please try again later.')
  }
}
