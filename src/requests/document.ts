import apiClient from '@/utils/api'
import { z } from 'zod'
import { paginationResponseSchema } from './utils'

export const documentRequestSchema = z.object({
  page: z.number().min(1, 'Page must be at least 1'),
  searchQuery: z.string().optional(),
  category: z.string().optional(),
  pageSize: z
    .number()
    .min(1, 'Page size must be at least 1')
    .max(100, 'Page size must not exceed 100'),
  type: z.array(
    z.string(),
  ).optional(),
  orderBy: z.string().optional(),
  direction: z.string().optional(),
  number: z.string().optional(),
  requester: z.string().optional(),
  from: z.string().optional(),
  to: z.string().optional()


})
export const documentSchema = z.object({
  id: z.number(),
  name: z.string(),
  requester: z.string().nullable(),
  object: z.string(),
  description: z.string().nullable(),
  doc_size: z.number().nullable(),
  doc_type: z.string().nullable(),
  doc_path: z.string(),
  categories: z.object({
    label: z.string(),
  }),
  publishedAt: z.date().nullable().optional(),
  date_creation: z.string().nullable().optional(),
  created_at: z.string(),
})
export type TDocumentType = z.infer<typeof documentRequestSchema>['type']

export type IDocument = z.infer<typeof documentSchema>

export const listDocumentResponseSchema = paginationResponseSchema.extend({
  data: z.array(documentSchema),
})
export type IListDocumentResponse = z.infer<typeof listDocumentResponseSchema>

export type IDocumentRequest = z.infer<typeof documentRequestSchema>


export const getDocumentation = async (
  request: IDocumentRequest,
): Promise<IListDocumentResponse> => {
  try {
    const response = await apiClient.get('/documentation/documentation', { params: request })
    if (response.status !== 200) {
      throw new Error('Unable to fetch documents. Please try again later.')
    }
    if (!listDocumentResponseSchema.safeParse(response.data).success) {
      //console.log(listDocumentResponseSchema.safeParse(response.data).error)
      throw new Error(`Unable to fetch documents. Please try again later.${response.data.data}`)
    }
    return listDocumentResponseSchema.parse(response.data)
  } catch (error) {
    console.error('Failed to fetch documents:', error)
    throw new Error('Unable to fetch documents. Please try again later.')
  }
}

export const getDocumentationByCategorie = async (
  request: IDocumentRequest,
): Promise<IListDocumentResponse> => {
  try {
    const response = await apiClient.get('/documentation', { params: request })
    if (response.status !== 200) {
      throw new Error('Unable to fetch documents. Please try again later.')
    }
    if (!listDocumentResponseSchema.safeParse(response.data).success) {
      //console.log(listDocumentResponseSchema.safeParse(response.data).error)
      throw new Error(`Unable to fetch documents. Please try again later.${response.data.data}`)
    }
    return listDocumentResponseSchema.parse(response.data)
  } catch (error) {
    console.error('Failed to fetch documents:', error)
    throw new Error('Unable to fetch documents. Please try again later.')
  }
}

export const getDecisions = async (
  request: IDocumentRequest,
): Promise<IListDocumentResponse> => {
  try {
    const response = await apiClient.get('documentation/decisions', { params: request })
    if (response.status !== 200) {
      throw new Error('Unable to fetch decisions. Please try again later.')
    }
    if (!listDocumentResponseSchema.safeParse(response.data).success) {
      //console.log(listDocumentResponseSchema.safeParse(response.data).error)
      throw new Error(`Unable to fetch decisions. Please try again later.${response.data.data}`)
    }
    return listDocumentResponseSchema.parse(response.data)
  } catch (error) {
    console.error('Failed to fetch decisions:', error)
    throw new Error('Unable to fetch decisions. Please try again later.')
  }
}

export const getLois = async (
  request: IDocumentRequest,
): Promise<IListDocumentResponse> => {
  try {
    const response = await apiClient.get('documentation/lois', { params: request })
    if (response.status !== 200) {
      throw new Error('Unable to fetch lois. Please try again later.')
    }
    if (!listDocumentResponseSchema.safeParse(response.data).success) {
      //console.log(listDocumentResponseSchema.safeParse(response.data).error)
      throw new Error(`Unable to fetch lois. Please try again later.${response.data.data}`)
    }
    return listDocumentResponseSchema.parse(response.data)
  } catch (error) {
    console.error('Failed to fetch lois:', error)
    throw new Error('Unable to fetch lois. Please try again later.')
  }
}


