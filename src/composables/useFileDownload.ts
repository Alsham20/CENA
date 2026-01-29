import { ref } from 'vue'
import { resourceUrl } from '@/utils/resource'

export function useFileDownload() {
  const isDownloading = ref(false)
  const error = ref<string | null>(null)

  const downloadFile = async (url: string, filename: string): Promise<void> => {
    isDownloading.value = true
    error.value = null

    try {
      const response = await fetch(resourceUrl +url, {
        method: 'GET',
      })

      if (!response.ok) {
        throw new Error(`Failed to download file: ${response.statusText}`)
      }

      const blob = await response.blob()
      const link = document.createElement('a')
      link.href = URL.createObjectURL(blob)
      link.download = filename
      document.body.appendChild(link)
      link.click()
      document.body.removeChild(link)

      // Revoke the blob URL to free up memory
      URL.revokeObjectURL(link.href)
      // eslint-disable-next-line @typescript-eslint/no-explicit-any
    } catch (err: any) {
      error.value = err.message || 'An error occurred while downloading the file.'
    } finally {
      isDownloading.value = false
    }
  }

  return {
    isDownloading,
    error,
    resourceUrl,
    downloadFile,
  }
}
