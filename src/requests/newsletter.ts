import { z } from 'zod'
import apiClient from '@/utils/api'

export const addNewsletterSchema = z.object({
  email: z.string().email(),
})
export const unsubscribeNewsletterSchema = z.object({
  confirmToken: z.string().max(2000),
})
export const addNewsletterResquestSchema = z.object({
  email: z.string().email(),
})
export type TAddNewsletterRequest = z.infer<typeof addNewsletterResquestSchema>

export type TUnsubscribeNewsletterRequest = z.infer<typeof unsubscribeNewsletterSchema>


export const addNewsletter = async (input: TAddNewsletterRequest) => {
  return apiClient.post('/news-letter', input)
}

export const unsubscribeNewsletter = async (input: TAddNewsletterRequest) => {
  return apiClient.post('/news-letter/unsubscribe', input)
}

export const unsubscribeConfirmNewsletter = async (input: TUnsubscribeNewsletterRequest) => {
  return apiClient.post('/news-letter/unsubscribe/confirm', input)
}
