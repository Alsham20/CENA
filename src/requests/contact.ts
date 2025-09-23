import { z } from 'zod'
import apiClient from '@/utils/api'

export const addContactSchema = z.object({
  nom: z.string(),
  prenom: z.string(),
  objet: z.string(),
  email: z.string().email(),
  telephone: z.string(),
  message: z.string(),
})
export const addContactResquestSchema = z.object({
  name: z.string(),
  mail: z.string().email(),
  object: z.string(),
  phone: z.string(),
  message: z.string(),
  recaptchaResponse:z.string(),
})
export type TAddContactRequest = z.infer<typeof addContactResquestSchema>
export const addContact = async (input: TAddContactRequest) => {
  return apiClient.post('/contact', input)
}
