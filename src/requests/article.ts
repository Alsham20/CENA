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

export const activitySchema = z.object({
  id: z.number(),
  author: z.number(),
  label: z.string(),
  type: z.string(),
  created_at: z.string().nullable(),
  updated_at: z.string().nullable(),
})

export const articleSchema = z.object({
  id: z.number(),
  title: z.string(),
  slug: z.string().nullable(),
  resume: z.string().nullable(),
  poster: z.number().nullable(),
  publications_count: z.number().nullable(),
  content: z.string().nullable(),
  content_keywords: z.string().nullable(),
  content_description: z.string().nullable(),
  tags: z.string().nullable(),
  is_published: z.number(),
  is_featured: z.number(),
  is_private: z.number(),
  activities: activitySchema.nullable(),
  categories: categorySchema.nullable(),
  created_at: z.string(),
  updated_at: z.string().nullable(),
  image: mediaSchema.nullable(),
  date_article: z.string(),
})

export type TArticle = z.infer<typeof articleSchema>

export const listArticlesRequestSchema = paginationRequestSchema.extend({
  searchQuery: z.string().optional(),
})

export type TListArticlesRequest = z.infer<typeof listArticlesRequestSchema>

export const listArticlesResponseSchema = paginationResponseSchema.extend({
  data: z.array(articleSchema),
})

export const listSliderArticlesResponseSchema = z.array(articleSchema)

export type TListArticlesResponse = z.infer<typeof listArticlesResponseSchema>
export type TListSliderArticlesResponse = z.infer<typeof listSliderArticlesResponseSchema>
export const getArticleRequestSchema = z.object({
  slug: z.string(),
})
export type TGetArticleRequest = z.infer<typeof getArticleRequestSchema>
export const getArticleResponseSchema = articleSchema
export type TGetArticleResponse = z.infer<typeof getArticleResponseSchema>

export const listArticles = async (
  payload: TListArticlesRequest,
): Promise<TListArticlesResponse> => {
  try {
    const response = await apiClient.get(`/articles`, { params: payload })
    if (response.status !== 200) {
      throw new Error('Unable to fetch article. Please try again later.')
    }
    if (!listArticlesResponseSchema.safeParse(response.data).success) {
      // console.log(listArticlesResponseSchema.safeParse(response.data).error)
      throw new Error('Unable to parse article. Please try again later.')
    }
    return listArticlesResponseSchema.parse(response.data)
  } catch (error) {
    console.error('Failed to fetch article:', error)
    throw new Error('Unable to fetch article. Please try again later.')
  }
}
export const listSliderArticles = async (): Promise<TListSliderArticlesResponse> => {
  try {
    const response = await apiClient.get(`/articles/slider`)
    if (response.status !== 200) {
      throw new Error('Unable to fetch article. Please try again later.')
    }
    if (!listSliderArticlesResponseSchema.safeParse(response.data).success) {
      //console.log(listSliderArticlesResponseSchema.safeParse(response.data).error)
      throw new Error('Unable to parse article. Please try again later.')
    }
    return listSliderArticlesResponseSchema.parse(response.data)
  } catch (error) {
    console.error('Failed to fetch article:', error)
    throw new Error('Unable to fetch article. Please try again later.')
  }
}

export const listArchives = async (
  payload: TListArticlesRequest,
): Promise<TListArticlesResponse> => {
  try {
    const response = await apiClient.get(`/articles/archives`, { params: payload })
    if (response.status !== 200) {
      throw new Error('Unable to fetch archives. Please try again later.')
    }
    if (!listArticlesResponseSchema.safeParse(response.data).success) {
      //console.log(listArticlesResponseSchema.safeParse(response.data).error)
      throw new Error('Unable to parse archives. Please try again later.')
    }
    return listArticlesResponseSchema.parse(response.data)
  } catch (error) {
    console.error('Failed to fetch archives:', error)
    throw new Error('Unable to fetch archives. Please try again later.')
  }
}

export const getArticle = async (payload: TGetArticleRequest): Promise<TGetArticleResponse> => {
  try {
    const response = await apiClient.get(`/articles/${payload.slug}/show`)
    if (response.status !== 200) {
      throw new Error('Unable to fetch article. Please try again later.')
    }
    if (!getArticleResponseSchema.safeParse(response.data).success) {
      //console.log(getArticleResponseSchema.safeParse(response.data).error)
      throw new Error('Unable to parse article. Please try again later.')
    }
    return getArticleResponseSchema.parse(response.data)
  } catch (error) {
    console.error('Failed to fetch article:', error)
    throw new Error('Unable to fetch article. Please try again later.')
  }
}
