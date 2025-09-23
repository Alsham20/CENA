import { z } from 'zod'

export const paginationResponseSchema = z.object({
  current_page: z.number(),
  per_page: z.number(),
  last_page: z.number(),
  total: z.number(),
})

export const paginationRequestSchema = z.object({
  page: z.number().min(1, 'Page must be at least 1'),
  pageSize: z
    .number()
    .min(1, 'Page size must be at least 1')
    .max(100, 'Page size must not exceed 100'),
  orderBy: z.string().optional(),
  orderDirection: z.string().optional(),
})
