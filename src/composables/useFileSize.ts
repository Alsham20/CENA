/**
 * Converts a file size in kilobytes (KB) to a human-readable format.
 * @param {number} sizeInKB - The file size in kilobytes (KB).
 * @returns {string} - The formatted file size (e.g., '1.2 MB', '345 KB').
 */
export function useFileSize() {
  const formatFileSize = (sizeInKB: number): string => {
    if (isNaN(sizeInKB) || sizeInKB < 0) {
      console.error('Invalid file size:', sizeInKB)
      return 'Invalid size'
    }

    const units = ['KB', 'MB', 'GB', 'TB']
    let size = sizeInKB
    let unitIndex = 0

    while (size >= 1024 && unitIndex < units.length - 1) {
      size /= 1024
      unitIndex++
    }

    return `${size.toFixed(1)} ${units[unitIndex]}`
  }

  return {
    formatFileSize,
  }
}
