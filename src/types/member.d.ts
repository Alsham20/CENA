interface Member {
  id: number
  firstName: string
  lastName: string
  position: string
  avatarUrl: string
  biographyUrl?: string
  socialLinks?: {
    facebook?: string
    twitter?: string
    linkedin?: string
  }
}