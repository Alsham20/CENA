import type { mediaSchema } from '@/requests/member'
import { z } from 'zod'

/**
 * Get the media url
 * @param {string} media - The media object
 * @returns {string} - The media url
 */
export type TMedia = z.infer<typeof mediaSchema>
export function useMedia() {
  const getMediaUrl = (media: TMedia | null | undefined): string | null => {
    if (!media) return null
    return media.base_url + media.path + '/' + media.name
  }

  return {
    getMediaUrl,
  }
}
