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

export const activitySchema = z.object({
  id: z.number(),
  author: z.number(),
  label: z.string(),
  type: z.string(),
  created_at: z.string().nullable(),
  updated_at: z.string().nullable(),
})

export const videoSchema = z.object({
  id: z.number(),
  title: z.string(),
  video_description: z.string().nullable(),
  date_video: z.string(),
  video_path: z.string(),
  is_published: z.number(),
  activities: activitySchema.nullable(),
  categories: categorySchema.nullable(),
  created_at: z.string(),
  updated_at: z.string().nullable(),
})

export type TVideo = z.infer<typeof videoSchema>

export const listVideosRequestSchema = paginationRequestSchema.extend({
  searchQuery: z.string().optional(),
})

export type TListVideosRequest = z.infer<typeof listVideosRequestSchema>

export const listVideosResponseSchema = paginationResponseSchema.extend({
  data: z.array(videoSchema),
})

export const listSliderVideosResponseSchema = z.array(videoSchema)

export type TListVideosResponse = z.infer<typeof listVideosResponseSchema>
export const getVideoRequestSchema = z.object({
  slug: z.string(),
})
export type TGetVideoRequest = z.infer<typeof getVideoRequestSchema>
export const getVideoResponseSchema = videoSchema
export type TGetVideoResponse = z.infer<typeof getVideoResponseSchema>

export const listVideos = async (
  payload: TListVideosRequest,
): Promise<TListVideosResponse> => {
  try {
    const response = await apiClient.get(`/videos`, { params: payload })
    if (response.status !== 200) {
      throw new Error('Unable to fetch video. Please try again later.')
    }
    if (!listVideosResponseSchema.safeParse(response.data).success) {
      console.log(listVideosResponseSchema.safeParse(response.data).error)
      throw new Error('Unable to parse video. Please try again later.')
    }
    return listVideosResponseSchema.parse(response.data)
  } catch (error) {
    console.error('Failed to fetch video:', error)
    throw new Error('Unable to fetch video. Please try again later.')
  }
}