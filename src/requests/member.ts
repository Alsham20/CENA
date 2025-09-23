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
export const memberSchema = z.object({
  id: z.number(),
  fonction: z.string().nullable().optional(),
  avatar: z.number().nullable(),
  firstname: z.string(),
  lastname: z.string(),
  title: z.string().nullable().optional(),
  description: z.string().nullable().optional(),
  created_at: z.string(),
  updated_at: z.string().nullable(),
  media: mediaSchema.nullable(),
})

export type TMember = z.infer<typeof memberSchema>

export const listMembersRequestSchema = paginationRequestSchema.extend({
  search: z.string().optional(),
})

export type TListMembersRequest = z.infer<typeof listMembersRequestSchema>

export const listMembersResponseSchema = paginationResponseSchema.extend({
  data: z.array(memberSchema),
})

export type TListMembersResponse = z.infer<typeof listMembersResponseSchema>

export const listMembers = async (payload: TListMembersRequest): Promise<TListMembersResponse> => {
  try {
    const response = await apiClient.get(`/teams`, { params: payload })
    if (response.status !== 200) {
      throw new Error('Unable to fetch page. Please try again later.')
    }
    if (!listMembersResponseSchema.safeParse(response.data).success) {
      //console.log(listMembersResponseSchema.safeParse(response.data).error)
      throw new Error('Unable to parse page. Please try again later.')
    }
    return listMembersResponseSchema.parse(response.data)
  } catch (error) {
    console.error('Failed to fetch page:', error)
    throw new Error('Unable to fetch page. Please try again later.')
  }
}
