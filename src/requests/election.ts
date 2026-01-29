import { z } from 'zod'
import { paginationRequestSchema, paginationResponseSchema } from './utils'
import apiClient from '@/utils/api'
import { categorySchema } from './article'
export const resultatSchema = z.object({
    id: z.number(),
    title: z.string(),
    url: z.string(),
    zone: z.string().nullable(),
    date_resultat: z.string().nullable(),
    is_published: z.number(),
    is_featured: z.number(),
    is_deleted: z.number(),
    is_archive: z.number(),
    author_id: z.number(),
    created_at: z.string(),
    updated_at: z.string().nullable(),
})
export const electionSchema = z.object({
    id: z.number(),
    title: z.string().nullable().optional(),
    year: z.string().nullable(),
    date_election: z.string().nullable(),
    description: z.string().nullable().optional(),
    is_published: z.number(),
    is_featured: z.number(),
    is_deleted: z.number(),
    is_archive: z.number(),
    categories: categorySchema,
    resultats: z.array(resultatSchema),
    created_at: z.string(),
    updated_at: z.string().nullable(),
})

export type TElection = z.infer<typeof electionSchema>

export type TResultat = z.infer<typeof resultatSchema>


export const listElectionsRequestSchema = paginationRequestSchema.extend({
    search: z.string().optional(),
    category: z.string().optional(),
    year: z.string().optional()
})

export type TListElectionsRequest = z.infer<typeof listElectionsRequestSchema>

export const listElectionsResponseSchema = paginationResponseSchema.extend({
    data: z.array(electionSchema),
})

export type TListElectionsResponse = z.infer<typeof listElectionsResponseSchema>

export const listElections = async (payload: TListElectionsRequest): Promise<TListElectionsResponse> => {
    try {
        const response = await apiClient.get(`/elections`, { params: payload })
        if (response.status !== 200) {
            throw new Error('Unable to fetch election. Please try again later.')
        }
        if (!listElectionsResponseSchema.safeParse(response.data).success) {
            console.log(listElectionsResponseSchema.safeParse(response.data).error)
            throw new Error('Unable to parse election. Please try again later.')
        }
        return listElectionsResponseSchema.parse(response.data)
    } catch (error) {
        console.error('Failed to fetch election:', error)
        throw new Error('Unable to fetch election. Please try again later.')
    }
}
