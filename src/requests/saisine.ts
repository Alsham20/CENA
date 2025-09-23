import { z } from 'zod'
import apiClient from '@/utils/api'

// Taille maximale en octets (20 Mo)
const MAX_FILE_SIZE = 20 * 1024 * 1024

// Schéma de validation du formulaire
export const addSaisineSchema = z.object({
  nom: z.string(),
  prenom: z.string(),
  fonction: z.string(),
  adresse: z.string(),
  email: z.string().email(),
  telephone: z.string(),
  motif: z.string(),
  message: z.string(),
  anonyme: z.boolean(),
  document: z
    .array(
      z
        .instanceof(File)
        .refine(
          (file) =>
            ['application/pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'].includes(file.type),
          { message: 'Le document doit être un fichier PDF ou DOCX' },
        )
        .refine((file) => file.size <= MAX_FILE_SIZE, {
          message: 'La taille maximale du fichier est de 20 Mo',
        }),
    ).nullable(),
})

// Schéma de validation de la requête API
export const addSaisineRequestSchema = z.object({
  name: z.string(),
  fonction: z.string(),
  address: z.string(),
  mail: z.string().email(),
  phone: z.string(),
  motif: z.string(),
  message: z.string(),
  recaptchaResponse:z.string(),
  anonyme: z.boolean(),
  document: z
    .array(
      z
        .instanceof(File)
        .refine(
          (file) =>
            ['application/pdf'].includes(file.type),
          { message: 'Le document doit être un fichier PDF' },
        )
        .refine((file) => file.size <= MAX_FILE_SIZE, {
          message: 'La taille maximale du fichier est de 20 Mo',
        }),
    ).nullable(),
})

export type TAddSaisineRequest = z.infer<typeof addSaisineRequestSchema>

// Fonction pour soumettre la requête
export const addSaisine = async (input: FormData) => {
  return apiClient.post('/saisine', input, {
    headers: {
      'Content-Type': 'multipart/form-data',
    },
  })
}
