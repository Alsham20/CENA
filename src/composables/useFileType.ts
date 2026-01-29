/**
 * Composable pour identifier le type d'un fichier à partir de son nom ou URL.
 */
export function useFileType() {
  // Mapping des extensions vers les types de fichiers
  const fileTypeMap: Record<string, { label: string; category: string }> = {
    // Documents PDF
    pdf: { label: 'PDF', category: 'document' },

    // Documents Word
    doc: { label: 'Word', category: 'document' },
    docx: { label: 'Word', category: 'document' },

    // Documents Excel
    xls: { label: 'Excel', category: 'spreadsheet' },
    xlsx: { label: 'Excel', category: 'spreadsheet' },
    csv: { label: 'CSV', category: 'spreadsheet' },

    // Documents PowerPoint
    ppt: { label: 'PowerPoint', category: 'presentation' },
    pptx: { label: 'PowerPoint', category: 'presentation' },

    // Images
    jpg: { label: 'Image', category: 'image' },
    jpeg: { label: 'Image', category: 'image' },
    png: { label: 'Image', category: 'image' },
    gif: { label: 'Image', category: 'image' },
    webp: { label: 'Image', category: 'image' },
    svg: { label: 'Image', category: 'image' },

    // Vidéos
    mp4: { label: 'Vidéo', category: 'video' },
    avi: { label: 'Vidéo', category: 'video' },
    mov: { label: 'Vidéo', category: 'video' },
    mkv: { label: 'Vidéo', category: 'video' },

    // Audio
    mp3: { label: 'Audio', category: 'audio' },
    wav: { label: 'Audio', category: 'audio' },

    // Archives
    zip: { label: 'Archive', category: 'archive' },
    rar: { label: 'Archive', category: 'archive' },
    '7z': { label: 'Archive', category: 'archive' },

    // Texte
    txt: { label: 'Texte', category: 'text' },
    rtf: { label: 'RTF', category: 'text' },
  }

  /**
   * Extrait l'extension d'un fichier à partir de son nom ou URL.
   * @param {string} fileNameOrUrl - Le nom du fichier ou son URL.
   * @returns {string | null} - L'extension en minuscules ou null si non trouvée.
   */
  const getFileExtension = (fileNameOrUrl: string): string | null => {
    if (!fileNameOrUrl) return null

    // Nettoyer l'URL (enlever les paramètres de requête)
    const cleanUrl = fileNameOrUrl.split('?')[0]

    // Extraire le nom du fichier
    const fileName = cleanUrl.split('/').pop() || ''

    // Extraire l'extension
    const parts = fileName.split('.')
    if (parts.length < 2) return null

    return parts.pop()?.toLowerCase() || null
  }

  /**
   * Retourne le type de fichier lisible.
   * @param {string} fileNameOrUrl - Le nom du fichier ou son URL.
   * @returns {string} - Le type de fichier (ex: 'PDF', 'Word', 'Image').
   */
  const getFileType = (fileNameOrUrl: string): string => {
    const extension = getFileExtension(fileNameOrUrl)
    if (!extension) return 'Fichier'

    return fileTypeMap[extension]?.label || extension.toUpperCase()
  }

  /**
   * Retourne la catégorie du fichier.
   * @param {string} fileNameOrUrl - Le nom du fichier ou son URL.
   * @returns {string} - La catégorie (ex: 'document', 'image', 'video').
   */
  const getFileCategory = (fileNameOrUrl: string): string => {
    const extension = getFileExtension(fileNameOrUrl)
    if (!extension) return 'unknown'

    return fileTypeMap[extension]?.category || 'unknown'
  }

  /**
   * Vérifie si le fichier est d'un type spécifique.
   * @param {string} fileNameOrUrl - Le nom du fichier ou son URL.
   * @param {string} type - Le type à vérifier (ex: 'PDF', 'Word').
   * @returns {boolean}
   */
  const isFileType = (fileNameOrUrl: string, type: string): boolean => {
    return getFileType(fileNameOrUrl).toLowerCase() === type.toLowerCase()
  }

  /**
   * Vérifie si le fichier appartient à une catégorie.
   * @param {string} fileNameOrUrl - Le nom du fichier ou son URL.
   * @param {string} category - La catégorie à vérifier (ex: 'document', 'image').
   * @returns {boolean}
   */
  const isFileCategory = (fileNameOrUrl: string, category: string): boolean => {
    return getFileCategory(fileNameOrUrl).toLowerCase() === category.toLowerCase()
  }

  return {
    getFileExtension,
    getFileType,
    getFileCategory,
    isFileType,
    isFileCategory,
  }
}
