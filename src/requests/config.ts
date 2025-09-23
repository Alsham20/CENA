import apiClient from '@/utils/api'
import { z } from 'zod'
//'key', 'value', 'label', 'type', 'is_editable'
export const configSchema = z.object({
  key: z.string(),
  value: z.string(),
  label: z.string(),
  type: z.string(),
})

export type TConfig = z.infer<typeof configSchema>

export const getConfigRequestSchema = z.object({
  key: z.string(),
})

export const listConfigsRequestSchema = z.object({
  key: z.string(),
})
export const listConfigsResponseSchema = z.array(configSchema)
export type TListConfigsRequest = z.infer<typeof listConfigsRequestSchema>
export type TListConfigsResponse = z.infer<typeof listConfigsResponseSchema>
export const listConfigs = async (): Promise<TConfig[]> => {
  try {
    const response = await apiClient.get(`/site/parametres`)
    if (response.status !== 200) {
      throw new Error('Unable to fetch page. Please try again later.')
    }
    if (!listConfigsResponseSchema.safeParse(response.data).success) {
      //console.log(listConfigsResponseSchema.safeParse(response.data).error)
      throw new Error('Unable to parse page. Please try again later.')
    }
    return listConfigsResponseSchema.parse(response.data)
  } catch (error) {
    console.error('Failed to fetch page:', error)
    throw new Error('Unable to fetch page. Please try again later.')
  }
}
