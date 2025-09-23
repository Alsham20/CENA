import { z } from 'zod'
import { paginationRequestSchema, paginationResponseSchema } from './utils'
import apiClient from '@/utils/api'
import { mediaSchema } from './member'

export const pageSchema = z.object({
  id: z.number(),
  title: z.string().nullable().optional(),
  slug: z.string(),
  content: z.string().nullable().optional(),
  tags: z.string().nullable().optional(),
  resume: z.string().nullable().optional(),
  content_description: z.string().nullable().optional(),
  content_keywords: z.string().nullable().optional(),
  created_at: z.string(),
  updated_at: z.string().nullable().optional(),
  poster_media: mediaSchema.nullable().optional(),
})

export type TPage = z.infer<typeof pageSchema>

export const listPagesRequestSchema = paginationRequestSchema.extend({
  searchQuery: z.string().optional(),
})
export type TListPagesRequest = z.infer<typeof listPagesRequestSchema>

export const listPagesResponseSchema = paginationResponseSchema.extend({
  data: z.array(pageSchema),
})
export type TListPagesResponse = z.infer<typeof listPagesResponseSchema>

export const getPageRequestSchema = z.object({
  slug: z.string(),
})
export type TGetPageRequest = z.infer<typeof getPageRequestSchema>
export const getPageResponseSchema = pageSchema
export type TGetPageResponse = z.infer<typeof getPageResponseSchema>
export const getPage = async (payload: TGetPageRequest): Promise<TGetPageResponse | null> => {
  try {
    const response = await apiClient.get(`/pages/${payload.slug}`)
    if (response.status !== 200) {
      throw new Error('Unable to fetch page. Please try again later.')
    }
    if (!getPageResponseSchema.safeParse(response.data).success) {
      //console.log(getPageResponseSchema.safeParse(response.data).error)
      return null
    }
    return getPageResponseSchema.parse(response.data)
  } catch (error) {
    console.error('Failed to fetch page:', error)
    throw new Error('Unable to fetch page. Please try again later.')
  }
}

export const listPages = async (payload: TListPagesRequest): Promise<TListPagesResponse> => {
  try {
    const response = await apiClient.get('/pages', { params: payload })
    if (response.status !== 200) {
      throw new Error('Unable to fetch pages. Please try again later.')
    }
    if (!listPagesResponseSchema.safeParse(response.data).success) {
      //console.log(listPagesResponseSchema.safeParse(response.data).error)
      throw new Error('Unable to fetch pages. Please try again later.')
    }
    return listPagesResponseSchema.parse(response.data)
  } catch (error) {
    console.error('Failed to fetch pages:', error)
    throw new Error('Unable to fetch pages. Please try again later.')
  }
}
