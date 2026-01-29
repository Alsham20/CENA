<script setup lang="ts">
import DigitalPlatforms from './DigitalPlatformsView.vue'

// Vous pouvez également personnaliser les plateformes
interface Platform {
  id: number
  title: string
  description: string
  url: string
  icon: string
  color: string
}

const platforms: Platform[] = [
  {
    id: 1,
    title: 'E-Learning',
    description: 'Plateforme de formation en ligne pour les acteurs électoraux et les citoyens. Accédez à des modules de formation interactifs et obtenez vos certifications.',
    url: 'https://elearning.cena.bj',
    icon: 'graduation',
    color: 'green'
  },
  {
    id: 2,
    title: 'E-Accréditation',
    description: 'Système de gestion des accréditations pour observateurs nationaux et internationaux, journalistes et délégués des partis politiques.',
    url: 'https://eaccreditation.cena.bj/',
    icon: 'badge',
    color: 'yellow'
  },
  {
    id: 3,
    title: 'E-Recrutement',
    description: 'Plateforme de recrutement transparent des agents électoraux, superviseurs et personnel temporaire pour les opérations électorales.',
    url: 'https://erecrutement.cena.bj/',
    icon: 'users',
    color: 'red'
  }
]

// Fonction pour ouvrir la plateforme
const openPlatform = (url: string) => {
  window.open(url, '_blank', 'noopener,noreferrer')
}

// Obtenir les classes de couleur selon la plateforme
const getColorClasses = (color: string) => {
  const colorMap: Record<string, { bg: string, hover: string, icon: string, badge: string }> = {
    blue: {
      bg: 'bg-green-50',
      hover: 'group-hover:bg-green-600',
      icon: 'text-green-600',
      badge: 'bg-green-600'
    },
    yellow: {
      bg: 'bg-yellow-50',
      hover: 'group-hover:bg-yellow-400',
      icon: 'text-yellow-400',
      badge: 'bg-yellow-400'
    },
    red: {
      bg: 'bg-red-50',
      hover: 'group-hover:bg-red-600',
      icon: 'text-red-600',
      badge: 'bg-red-600'
    }
  }
  return colorMap[color] || colorMap.blue
}

// Obtenir l'icône SVG
const getIconPath = (icon: string) => {
  const icons: Record<string, string> = {
    graduation: 'M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222',
    badge: 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z',
    users: 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'
  }
  return icons[icon] || icons.graduation
}
</script>

<template>
  <div class="min-h-screen">
    <section class="py-16 bg-[#0E6258] relative overflow-hidden">
    <!-- Motif de fond décoratif -->
    <div class="absolute inset-0 opacity-10">
      <div class="absolute top-0 left-0 w-96 h-96 bg-white rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
      <div class="absolute bottom-0 right-0 w-96 h-96 bg-white rounded-full blur-3xl translate-x-1/2 translate-y-1/2"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
      <!-- En-tête de section -->
      <div class="text-center mb-12">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-white bg-opacity-20 rounded-full mb-4">
          <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
          </svg>
        </div>
        <h2 class="text-4xl font-bold text-white mb-4">
          NOS PLATEFORMES DIGITALES
        </h2>
        <p class="text-blue-100 text-lg max-w-2xl mx-auto">
          Accédez à nos services en ligne pour faciliter vos démarches électorales
        </p>
      </div>

      <!-- Grille des plateformes -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
        <article 
          v-for="platform in platforms" 
          :key="platform.id"
          @click="openPlatform(platform.url)"
          class="group bg-white shadow-xl overflow-hidden cursor-pointer transform transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl"
        >
          <!-- En-tête colorée avec icône -->
          <div 
            class="relative h-32 flex items-center justify-center transition-colors duration-300"
            :class="[getColorClasses(platform.color).bg, getColorClasses(platform.color).hover]"
          >
            <!-- Icône -->
            <div class="relative z-10 transform transition-transform duration-300 group-hover:scale-110">
              <svg 
                class="w-16 h-16 transition-colors duration-300"
                :class="[getColorClasses(platform.color).icon, 'group-hover:text-white']"
                fill="none" 
                stroke="currentColor" 
                viewBox="0 0 24 24"
              >
                <path 
                  stroke-linecap="round" 
                  stroke-linejoin="round" 
                  stroke-width="2" 
                  :d="getIconPath(platform.icon)"
                />
              </svg>
            </div>

            <!-- Badge "Accéder" -->
            <div 
              class="absolute top-4 right-4 px-3 py-1 text-white text-xs font-semibold rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"
              :class="getColorClasses(platform.color).badge"
            >
              Accéder →
            </div>

            <!-- Motif décoratif -->
            <div class="absolute inset-0 opacity-20">
              <div class="absolute top-0 right-0 w-32 h-32 bg-white rounded-full blur-2xl translate-x-1/2 -translate-y-1/2"></div>
            </div>
          </div>

          <!-- Contenu -->
          <div class="p-6">
            <h3 class="text-2xl font-bold text-blue-900 mb-3 group-hover:text-green-600 transition-colors">
              {{ platform.title }}
            </h3>
            <p class="text-gray-600 leading-relaxed mb-4">
              {{ platform.description }}
            </p>

            <!-- Footer avec lien -->
            <div class="flex items-center justify-between pt-4 border-t border-gray-200">
              <span class="text-sm text-gray-500 truncate mr-2">
                {{ platform.url.replace('https://', '') }}
              </span>
              <div class="flex-shrink-0 w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center group-hover:bg-green-600 transition-colors">
                <svg class="w-4 h-4 text-gray-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg>
              </div>
            </div>
          </div>
        </article>
      </div>

      <!-- Message additionnel -->
      <!-- <div class="text-center mt-12">
        <p class="text-blue-100 text-sm">
          <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
          </svg>
          Toutes nos plateformes sont sécurisées et accessibles 24h/24
        </p>
      </div> -->
    </div>
  </section>
  </div>
</template>