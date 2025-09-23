import { z } from 'zod'
import { paginationRequestSchema, paginationResponseSchema } from './utils'
import apiClient from '@/utils/api'
export const categorySchema = z.object({
  id: z.number(),
  author: z.number(),
  parent: z.number().nullable(),
  label: z.string(),
  type: z.string(),
  created_at: z.string().nullable(),
  updated_at: z.string().nullable(),
})
export const faqSchema = z.object({
  id: z.number(),
  question: z.string(),
  answer: z.string(),
  is_active: z.number(),
  category_id: z.number(),
  position: z.number().nullable(),
  author_id: z.number(),
  order: z.number(),
  created_at: z.string().nullable(),
  updated_at: z.string().nullable(),
  categories: categorySchema.nullable(),
})

export type TFaq = z.infer<typeof faqSchema>

export const listFaqsRequestSchema = paginationRequestSchema.extend({
  search: z.string().optional(),
})

export type TListFaqsRequest = z.infer<typeof listFaqsRequestSchema>

export const listFaqsResponseSchema = paginationResponseSchema.extend({
  data: z.array(faqSchema),
})

export type TListFaqsResponse = z.infer<typeof listFaqsResponseSchema>

export const listFaqs = async (payload: TListFaqsRequest): Promise<TListFaqsResponse> => {
  try {
    const response = await apiClient.get(`/faqs`, { params: payload })
    if (response.status !== 200) {
      throw new Error('Unable to fetch page. Please try again later.')
    }
    if (!listFaqsResponseSchema.safeParse(response.data).success) {
      //console.log(listFaqsResponseSchema.safeParse(response.data).error)
      throw new Error('Unable to parse page. Please try again later.')
    }
    return listFaqsResponseSchema.parse(response.data)
  } catch (error) {
    console.error('Failed to fetch page:', error)
    throw new Error('Unable to fetch page. Please try again later.')
  }
}
