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
export const sliderSchema = z.object({
  id: z.number(),
  title: z.string(),
  created_at: z.string(),
  updated_at: z.string().nullable(),
  image: mediaSchema.nullable(),
})

export type TSlider = z.infer<typeof sliderSchema>

export const listSlidersRequestSchema = paginationRequestSchema.extend({
  search: z.string().optional(),
})

export type TListSlidersRequest = z.infer<typeof listSlidersRequestSchema>

export const listSlidersResponseSchema = paginationResponseSchema.extend({
  data: z.array(sliderSchema),
})

export type TListSlidersResponse = z.infer<typeof listSlidersResponseSchema>

export const listSliders = async (payload: TListSlidersRequest): Promise<TListSlidersResponse> => {
  try {
    const response = await apiClient.get(`/sliders`, { params: payload })
    if (response.status !== 200) {
      throw new Error('Unable to fetch page. Please try again later.')
    }
    if (!listSlidersResponseSchema.safeParse(response.data).success) {
      //console.log(listSlidersResponseSchema.safeParse(response.data).error)
      throw new Error('Unable to parse page. Please try again later.')
    }
    return listSlidersResponseSchema.parse(response.data)
  } catch (error) {
    console.error('Failed to fetch page:', error)
    throw new Error('Unable to fetch page. Please try again later.')
  }
}
