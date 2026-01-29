<template>
  <header class="bg-white shadow-lg sticky w-full z-50 top-0 left-0 right-0">
    <!-- <TopHeader /> -->
    <nav class=" h-full mx-auto max-w-full">
      <div class="w-full h-20 md:h-24 p-2 md:p-4 flex items-center justify-between">
        <RouterLink :to="'/'" class="flex items-center h-full bg-white">
          <img src="/assets/img/cena_lg_2.jpeg" class="h-16 w-48 md:h-18 md:w-64 object-cover" alt="Logo" />
        </RouterLink>
        <div class="hidden h-full lg:block">
          <div class="flex h-full space-x-10">
            <ul class="flex h-full">
              <li v-for="menu in menus" :key="menu.name" class="h-full flex items-center px-2"
                @mouseenter="toggleMenu(menu.name)" @mouseleave="closeMenu()">
                <RouterLink v-if="!menu.children" :to="menu.href"
                  class="flex items-center justify-center text-sm xl:text-lg font-[700] ease-in duration-300 py-1 uppercase"
                  :class="[
                    menu.active
                      ? 'text-[#0E6258] hover:text-[#0E6258] border-b-4 hover:border-[#0E6258] border-[#0E6258]'
                      : 'text-[#11845a] hover:text-[#0E6258] border-b-4 hover:border-[#0E6258] border-white',
                  ]">
                  {{ menu.name }}
                </RouterLink>
                <div v-else as="div" class="inline-block text-left px-1">
                  <a class="flex items-center h-full justify-center text-sm xl:text-lg font-[700] ease-in duration-300 py-1 uppercase"
                    :class="[
                      menu.active
                        ? 'text-[#0E6258] hover:text-[#0E6258] border-b-4 hover:border-[#0E6258] border-[#0E6258]'
                        : 'text-[#11845a] hover:text-[#0E6258] border-b-4 hover:border-[#0E6258] border-white',
                    ]">
                    {{ menu.name }}
                  </a>
                  <Transition enter-active-class="transition ease-out duration-100"
                    enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100"
                    leave-active-class="transition ease-in duration-75"
                    leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                    <ul v-if="activeMenu === menu.name"
                      class="absolute z-10 bg-white shadow-lg ring-black/5 focus:outline-none">
                      <div class="w-60">
                        <li v-for="item in menu.children" :key="item.name">
                          <RouterLink :to="item.href" @click="closeMenu">
                            <span
                              class="text-black border-none block p-3 text-xs font-[500] hover:bg-[#0E6258] hover:text-white uppercase"
                              href="#">{{ item.name }}</span>
                          </RouterLink>
                        </li>
                      </div>
                    </ul>
                  </Transition>
                </div>
              </li>
            </ul>
          </div>
        </div>
        <div class="flex space-x-2 justify-start">
          <div v-if="!isSearchOpen" class="flex items-center md:pe-4">
            <button @click="openSearch"
              class="flex items-center p-2 bg-[#11845a] text-white rounded-full focus:bg-[#0E6258]"
              :class="{ 'bg-[#11845a]': isSearchOpen }">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
            </button>
          </div>
          <!-- Réseaux sociaux -->
          <div class="lg:hidden h-full flex items-center">
            <!-- Bouton Menu Hamburger -->
            <button @click="toggleMobileMenu()" class="mobile-menu-button p-2 text-[#11845a]">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                class="w-8 h-8 sm:w-10 sm:h-10">
                <path v-if="!isMobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16" />
                <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
        </div>
      </div>
      <!-- Menu Mobile Déroulant -->
      <Transition enter-active-class="transition-all ease-out duration-300" enter-from-class="opacity-0 -translate-y-4"
        enter-to-class="opacity-100 translate-y-0" leave-active-class="transition-all ease-in duration-300"
        leave-from-class="opacity-100 translate-y-0" leave-to-class="opacity-0 -translate-y-4">
        <div v-if="isMobileMenuOpen"
          class="fixed left-0 right-0 top-20 h-[calc(100vh-5rem)] z-50 bg-white border-t border-t-gray-300 overflow-y-auto">
          <ul class=" pb-4">
            <li v-for="menu in menus" :key="menu.name">
              <RouterLink v-if="!menu.children" :to="menu.href"
                class="block p-4 text-[#0E6258] text-sm font-bold hover:bg-[#11845a] hover:text-white uppercase"
                :class="{ 'bg-[#0E6258] text-white': menu.active }" @click="closeMenu">
                {{ menu.name }}
              </RouterLink>
              <div v-else>
                <button @click="toggleMenu(menu.name)"
                  class="flex items-center justify-between w-full py-4 px-4 text-[#0E6258] text-sm font-bold hover:bg-[#11845a] hover:text-white"
                  :class="{ 'bg-[#0E6258] text-white': menu.active }">
                  {{ menu.name }}
                  <svg class="w-4 h-4 ml-2" :class="{ 'transform rotate-180': activeMenu === menu.name }" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" />
                  </svg>
                </button>
                <Transition enter-active-class="transition-all ease-out duration-300"
                  enter-from-class="opacity-0 max-h-0" enter-to-class="opacity-100 max-h-screen"
                  leave-active-class="transition-all ease-in duration-300" leave-from-class="opacity-100 max-h-screen"
                  leave-to-class="opacity-0 max-h-0">
                  <ul v-if="activeMenu === menu.name" class="bg-[#11845a]">
                    <li v-for="item in menu.children" :key="item.name">
                      <RouterLink :to="item.href"
                        class="block py-2 px-6 text-xs font-semibold hover:bg-[#0E6258] text-white uppercase" @click="closeMenu">
                        {{ item.name }}
                      </RouterLink>
                    </li>
                  </ul>
                </Transition>
              </div>
            </li>
          </ul>
        </div>
      </Transition>
      <div v-show="isSearchOpen" class="w-full transition-all duration-300 ease-in-out">
        <div class="flex items-center w-full px-4 py-3 space-x-8">
          <div class="flex-1 relative py-1 px-3 rounded-lg border-[#11845a] border-b">
            <div class="absolute inset-y-0 flex items-center pointer-events-none">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600 font-semibold" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
            </div>
            <input type="text"
              class="w-full text-xs sm:text-base text-gray-500 pl-8 placeholder-gray-500 border-0 focus:ring-0 focus:outline-none"
              placeholder="Rechercher sur le site internet" v-model="searchQuery" />
          </div>
          <button @click="closeSearch"
            class="p-2 rounded-full text-[#11845a] border-[#11845a] border transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
      </div>
    </nav>
  </header>
</template>
<script setup lang="ts">
import { onMounted, onUnmounted, ref, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router';

const activeMenu = ref<string | null>(null)
const isSearchOpen = ref(false)
const isMobileMenuOpen = ref(false)
const isSmallScreen = ref(false)
const searchQuery = ref('')
const route = useRoute()
const router = useRouter()

const menus = ref([
  // { name: 'ACCUEIL', href: '/', active: true }, 
  {
    name: 'CENA',
    href: '#',
    active: true,
    children: [
      { name: 'Présentation', href: '/presentation-de-la-cena' },
      { name: 'Missions de la CENA', href: '/missions-de-la-cena' },
      { name: 'President', href: '/president' },
      { name: 'Le Conseil Electoral', href: '/conseil-electoral' },
      { name: 'La Direction Générale des Elections', href: '/direction-generale-des-elections' },
    ],
  },
  // {
  //   name: 'LE VOTE',
  //   href: '/#',
  //   active: false,
  //   children: [
  //     { name: 'Comment voter ?', href: '/#' },
  //     { name: 'Le système éléctorale', href: '/#' },
  //     { name: 'Lexiques des élections', href: '/#' },
  //     { name: 'Abréviations et termes techniques', href: '/#' },
  //   ],
  // },
  {
    name: 'ELECTIONS',
    href: '#',
    active: false,
    children: [
      { name: 'Résultats récents', href: '/resultats-recents' },
      { name: 'Statistiques', href: '/statistiques' },
    ],
  },
  {
    name: 'ACTUALITES',
    href: '/documentation',
    active: false,
    children: [
      { name: 'Actualité', href: '/actualites' },
      { name: 'Communiqués', href: '/communiques' },
    ],
  },
  {
    name: 'RESSOURCES',
    href: '/contact',
    active: false,
    children: [
      { name: 'DECISIONS DU CONSEIL', href: '/ressources/decisions-du-conseil' },
      { name: 'TEXTES ET LOIS', href: '/ressources/textes-et-lois' },
      { name: 'GALLERIES', href: '/gallery' },
      { name: 'RESULTATS ELECTORAUX', href: '/ressources/resultats-electoraux'},
      { name: 'SERVICES EN LIGNE', href: '/ressources/digital-platforms'}
    ],
  },
  {
    name: 'CONTACT',
    href: '/contact',
    active: false,
    children: [
      { name: 'Centre d\'appel', href: '/centre-appel' },
      { name: 'Assistance technique des services en ligne', href: '/support-technique' },
    ],
  },

])

const toggleMenu = (menuName: string) => {
  activeMenu.value = activeMenu.value === menuName ? null : menuName
}

// const toggleMenu = (menuName: string) => {
//   activeMenu.value = menuName
//   //closeSearch()
// }

const toggleMobileMenu = () => {
  isMobileMenuOpen.value = !isMobileMenuOpen.value
  closeSearch()
}

const closeMenu = () => {
  activeMenu.value = null
}

// Fonction pour vérifier si un menu doit être actif en fonction de la route actuelle
const isMenuActive = (
  menu:
    | { name: string; href: string; active: boolean; children?: undefined }
    | { name: string; href: string; active: boolean; children: { name: string; href: string }[] },
) => {
  if (!route) return false
  if (route.name && typeof route.name === 'string' && route.name.includes(menu.name)) return true
  if (menu.children) {
    return menu.children.some((child) => child.href === route.path)
  }
  return false
}

// Mettre à jour l'état actif des menus en fonction de la route
const updateActiveMenus = () => {
  menus.value = menus.value.map((menu) => ({
    ...menu,
    active: isMenuActive(menu),
  }))
}

const handleResize = () => {
  isSmallScreen.value = window.innerWidth < 1024
}

const openSearch = () => {
  if (isSearchOpen.value == true) {
    closeSearch()
  } else {
    isSearchOpen.value = true
  }
  closeMenu()
}

const closeSearch = () => {
  isSearchOpen.value = false
  searchQuery.value = '' // Réinitialise la recherche
}

onMounted(() => {
  // Initial update
  updateActiveMenus()
  handleResize()

  // Watch for route changes
  watch(
    () => route.path,
    () => {
      updateActiveMenus()
      closeMenu()
    },
  )
})

onUnmounted(() => {
  window.removeEventListener('resize', handleResize)
})

</script>