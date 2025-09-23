<template>
  <header class="bg-white shadow-lg sticky w-full z-50 top-0 left-0 right-0">
    <!-- <TopHeader /> -->
    <nav class=" h-full space-y-6 mx-auto max-w-full">
      <div class="w-full h-24 p-2 md:p-4 flex items-center justify-between">
        <a href="#" class="flex items-center h-full bg-white">
          <img src="/assets/img/cena_lg_2.jpeg" class="h-18 w-64 object-cover" alt="Logo" />
        </a>
        <div class="hidden h-full lg:block">
          <div class="flex h-full space-x-10">
            <ul class="flex h-full">
              <li v-for="menu in menus" :key="menu.name" class="h-full flex items-center px-2"
                @mouseenter="toggleMenu(menu.name)" @mouseleave="closeMenu()">
                <RouterLink v-if="!menu.children" :to="menu.href"
                  class="flex items-center justify-center text-sm font-[700] ease-in duration-300 py-1" :class="[
                    menu.active
                      ? 'text-[#0E6258] hover:text-[#0E6258] border-b-4 hover:border-[#0E6258] border-[#0E6258]'
                      : 'text-[#11845a] hover:text-[#0E6258] border-b-4 hover:border-[#0E6258] border-white',
                  ]">
                  {{ menu.name }}
                </RouterLink>
                <div v-else as="div" class="inline-block text-left px-1">
                  <a class="flex items-center h-full justify-center text-sm font-[700] ease-in duration-300 py-1"
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
                              class="text-black border-none block p-3 text-sm font-[500] hover:bg-[#0E6258] hover:text-white"
                              href="#">{{ item.name }}</span>
                          </RouterLink>
                        </li>
                      </div>
                    </ul>
                  </Transition>
                </div>
              </li>
            </ul>
            <!-- <div class="h-full flex items-center">
              <button @click="openSearch"
                class="flex items-center h-10 px-3 bg-gray-100 rounded-full focus:bg-[#DC9122]"
                :class="{ 'bg-[#1880E7] text-white': isSearchOpen }">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
              </button>
            </div> -->
          </div>
        </div>
        <!-- <a href="#" class="flex items-center space-x-3 h-full px-4 bg-white">
          <img src="/assets/img/armoiriebenin.png" class="h-16 object-cover" alt="Logo" />
        </a> -->
        <!-- Réseaux sociaux -->
        <div class="flex items-center space-x-1 bg-[#11845a] rounded-full py-1 px-2">
          <a v-for="social in socialLinks" :key="social.name" :href="social.url" target="_blank"
            rel="noopener noreferrer"
            class="bg-[white] bg-opacity-0 p-1 rounded-full transition-all duration-200 hover:scale-110"
            :title="social.name">
            <component :is="social.icon" class="w-5 h-5" />
          </a>
        </div>
      </div>
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
              class="w-full text-xs text-gray-500 pl-8 placeholder-gray-500 border-0 focus:ring-0 focus:outline-none"
              placeholder="Rechercher sur le site internet" v-model="searchQuery" />
          </div>
          <button @click="closeSearch"
            class="p-2 rounded-3xl text-[#11845a] border-[#11845a] border transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
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
import { onMounted, onUnmounted, reactive, ref, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router';
import AppleIcon from '@/components/icons/AppleIcon.vue';
import PlayIcon from '@/components/icons/PlayIcon.vue';
import FacebookIcon from '@/components/icons/FacebookIcon.vue';
import TwitterIcon from '@/components/icons/TwitterIcon.vue';
import YoutubeIcon from '@/components/icons/YoutubeIcon.vue';

const activeMenu = ref<string | null>(null)
const isSearchOpen = ref(false)
const isSmallScreen = ref(false)
const searchQuery = ref('')
const route = useRoute()
const router = useRouter()

const menus = ref([
  // { name: 'ACCUEIL', href: '/', active: true }, 
  {
    name: 'LA CENA',
    href: '#',
    active: true,
    children: [
      { name: 'Présentation de la CENA', href: '/presentation-de-la-cena' },
      { name: 'Missions de la CENA', href: '/missions-de-la-cena' },
      { name: 'Fonctionnement de la CENA', href: '/fonctionnement-de-la-cena' },
      { name: 'Bureau', href: '/bureau' },
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
    name: 'LES ÉLECTIONS',
    href: '#',
    active: false,
    children: [
      { name: 'Résultats récents', href: '/#' },
      { name: 'Statistiques', href: '/#' },
    ],
  },
  {
    name: 'L\'ACTUALITÉ',
    href: '/documentation',
    active: false,
    children: [
      { name: 'Actualité', href: '/#' },
      { name: 'Communiqués', href: '/#' },
    ],
  },
  {
    name: 'RESSOURCES',
    href: '/contact',
    active: false,
    children: [
      { name: 'Documents', href: '/#' },
      { name: 'Textes de loi', href: '/#' },
      { name: 'Archives', href: '/#' },
      { name: 'Statistiques', href: '/#' },
    ],
  },
  // {
  //   name: 'MEDIA CENTER',
  //   href: '/contact',
  //   active: false,
  //   children: [
  //     { name: 'Centre des Médias et de l\'Information Électorale', href: '/#' },
  //     { name: 'Accréditations', href: '/#' },
  //     { name: 'Actualité', href: '/#' },
  //     { name: 'Communiqués', href: '/#' },
  //   ],
  // },
  { name: 'CONTACT', href: '/', active: false }, 

])

// Liens des réseaux sociaux
const socialLinks = reactive([
  {
    name: 'Apple',
    url: '#',
    icon: AppleIcon
  },
  {
    name: 'Google Play',
    url: '#',
    icon: PlayIcon
  },
  {
    name: 'Facebook',
    url: '#',
    icon: FacebookIcon
  },
  {
    name: 'Twitter',
    url: '#',
    icon: TwitterIcon
  },
  {
    name: 'YouTube',
    url: '#',
    icon: YoutubeIcon
  }
])

// const toggleMenu = (menuName: string) => {
//   activeMenu.value = activeMenu.value === menuName ? null : menuName
// }

const toggleMenu = (menuName: string) => {
  activeMenu.value = menuName
  //closeSearch()
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