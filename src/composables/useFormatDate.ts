export function useFormatDate() {
  const defaultOptions: Intl.DateTimeFormatOptions = {
    year: 'numeric',
    month: '2-digit',
    day: '2-digit',
  }

  /**
   * Formats a given date using Intl.DateTimeFormat.
   * @param {string | Date} date - The date to format.
   * @param {FormatDateOptions} options - Intl.DateTimeFormat options.
   * @param {string} locale - The locale string (default: 'en-GB').
   * @returns {string} - The formatted date string.
   */
  const formatDate = (
    date: string | Date,
    options: Intl.DateTimeFormatOptions = {},
    locale: string = 'en-GB',
  ): string => {
    try {
      const parsedDate = date instanceof Date ? date : new Date(date)
      return new Intl.DateTimeFormat(locale, { ...defaultOptions, ...options }).format(parsedDate)
    } catch (error) {
      console.error('Invalid date:', date, error)
      return 'Invalid Date'
    }
  }

  return {
    formatDate,
  }
}
