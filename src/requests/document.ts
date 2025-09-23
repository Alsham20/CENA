import apiClient from '@/utils/api'
import { z } from 'zod'
import { paginationResponseSchema } from './utils'

export const documentRequestSchema = z.object({
  view: z.enum(['opinion', 'document']).optional(),
  page: z.number().min(1, 'Page must be at least 1'),
  searchQuery: z.string().optional(),
  category: z.string().optional(),
  pageSize: z
    .number()
    .min(1, 'Page size must be at least 1')
    .max(100, 'Page size must not exceed 100'),
  type: z.array(
    z.enum([
      'Lois',
      'Ordonnances',
      'Décrets',
      'Arrêtés',
      'Rapports',
      'Statistiques',
      'Référentiels',
      'Décision',
      'Avis',
    ]),
  ),
  orderBy: z.string().optional(),
  direction: z.string().optional(),
})
export const documentSchema = z.object({
  id: z.number(),
  name: z.string(),
  doc_size: z.number().nullable(),
  doc_path: z.string(),
  categorie: z.object({
    label: z.enum([
      'Lois',
      'Ordonnances',
      'Décrets',
      'Arrêtés',
      'Rapports',
      'Statistiques',
      'Référentiels',
      'Décision',
      'Avis',
    ]),
  }),
  publishedAt: z.date().nullable().optional(),
  date_creation: z.string().nullable().optional(),
  created_at: z.string(),
})
export type TDocumentType = z.infer<typeof documentRequestSchema>['type'][number]

export type IDocument = z.infer<typeof documentSchema>

export const listDocumentResponseSchema = paginationResponseSchema.extend({
  data: z.array(documentSchema),
})
export type IListDocumentResponse = z.infer<typeof listDocumentResponseSchema>

export type IDocumentRequest = z.infer<typeof documentRequestSchema>

export const getOpinions = async (request: IDocumentRequest): Promise<IListDocumentResponse> => {
  try {
    const response = await apiClient.get('/documentation/avis-et-decisions', { params: request })
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
