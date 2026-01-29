<template>
  <nav class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4"
    aria-label="Table navigation">

    <!-- Pagination -->
    <ul class="inline-flex items-stretch -space-x-px">
      <!-- Bouton Previous -->
      <li>
        <button @click="goToPage(currentPage - 1)" :disabled="currentPage === 1" :class="[
          'flex items-center justify-center h-full py-1.5 px-3 ml-0 border transition-colors',
          currentPage === 1
            ? 'cursor-not-allowed opacity-50 text-gray-400 bg-base-200 border-gray-300'
            : 'text-gray-500 bg-base-200 border-gray-300 hover:bg-gray-100 hover:text-gray-700'
        ]">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="lucide lucide-chevron-left-icon lucide-chevron-left">
            <path d="m15 18-6-6 6-6" />
          </svg>
        </button>
      </li>

      <!-- Première page -->
      <li v-if="showFirstPage">
        <button @click="goToPage(1)" :class="[
          'flex items-center justify-center text-sm py-2 px-3 leading-tight border transition-colors',
          currentPage === 1
            ? 'z-10 text-white bg-[#11845a] border-[#11845a]'
            : 'text-gray-500 bg-base-200 border-gray-300 hover:bg-gray-100 hover:text-gray-700'
        ]">
          1
        </button>
      </li>

      <!-- Ellipsis gauche -->
      <li v-if="showLeftEllipsis">
        <span
          class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-base-200 border border-gray-300">
          ...
        </span>
      </li>

      <!-- Pages du milieu -->
      <li v-for="page in visiblePages" :key="page">
        <button @click="goToPage(page)" :class="[
          'flex items-center justify-center text-sm py-2.5 px-3 leading-tight border transition-colors',
          currentPage === page
            ? 'z-10 text-white bg-[#11845a]'
            : 'text-gray-500 bg-base-200 border-gray-300 hover:bg-gray-100 hover:text-gray-700'
        ]">
          {{ page }}
        </button>
      </li>

      <!-- Ellipsis droite -->
      <li v-if="showRightEllipsis">
        <span
          class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-base-200 border border-gray-300 ">
          ...
        </span>
      </li>

      <!-- Dernière page -->
      <li v-if="showLastPage">
        <button @click="goToPage(totalPages)" :class="[
          'flex items-center justify-center text-sm py-2 px-3 leading-tight border transition-colors',
          currentPage === totalPages
            ? 'z-10 text-white bg-[#11845a] border-[#11845a]'
            : 'text-gray-500 bg-base-200 border-gray-300 hover:bg-gray-100 hover:text-gray-700'
        ]">
          {{ totalPages }}
        </button>
      </li>

      <!-- Bouton Next -->
      <li>
        <button @click="goToPage(currentPage + 1)" :disabled="currentPage === totalPages" :class="[
          'flex items-center justify-center h-full py-1.5 px-3 leading-tight border transition-colors',
          currentPage === totalPages
            ? 'cursor-not-allowed opacity-50 text-gray-400 bg-base-200 border-gray-300'
            : 'text-gray-500 bg-base-200 border-gray-300 hover:bg-gray-100 hover:text-gray-700'
        ]">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right-icon lucide-chevron-right"><path d="m9 18 6-6-6-6"/></svg>        </button>
      </li>
    </ul>
  </nav>
</template>

<script setup lang="ts">
import { computed } from 'vue'

// Props
const props = defineProps({
  currentPage: {
    type: Number,
    required: true,
    default: 1
  },
  totalItems: {
    type: Number,
    required: true,
    default: 0
  },
  itemsPerPage: {
    type: Number,
    default: 10
  },
  maxVisiblePages: {
    type: Number,
    default: 5 // Nombre de pages visibles au milieu
  }
})

// Émissions
const emit = defineEmits(['page-change'])

// Calculs
const totalPages = computed(() => {
  return Math.ceil(props.totalItems / props.itemsPerPage)
})

const startItem = computed(() => {
  if (props.totalItems === 0) return 0
  return (props.currentPage - 1) * props.itemsPerPage + 1
})

const endItem = computed(() => {
  const end = props.currentPage * props.itemsPerPage
  return end > props.totalItems ? props.totalItems : end
})

// Logique pour afficher les pages visibles
const visiblePages = computed(() => {
  const pages = []
  const total = totalPages.value
  const current = props.currentPage
  const max = props.maxVisiblePages

  if (total <= max + 2) {
    // Si peu de pages, afficher toutes
    for (let i = 1; i <= total; i++) {
      pages.push(i)
    }
    return pages
  }

  // Calculer la plage de pages à afficher
  let start = Math.max(2, current - Math.floor(max / 2))
  let end = Math.min(total - 1, start + max - 1)

  // Ajuster si on est près du début ou de la fin
  if (end - start < max - 1) {
    start = Math.max(2, end - max + 1)
  }

  for (let i = start; i <= end; i++) {
    pages.push(i)
  }

  return pages
})

const showFirstPage = computed(() => {
  // Ne pas afficher la première page si elle est déjà dans visiblePages
  // Ou s'il y a très peu de pages (tout sera affiché dans visiblePages)
  if (totalPages.value <= props.maxVisiblePages + 2) {
    return false
  }
  return !visiblePages.value.includes(1)
})

const showLastPage = computed(() => {
  // Ne pas afficher la dernière page si elle est déjà dans visiblePages
  // Ou s'il y a très peu de pages (tout sera affiché dans visiblePages)
  if (totalPages.value <= props.maxVisiblePages + 2) {
    return false
  }
  return !visiblePages.value.includes(totalPages.value)
})

const showLeftEllipsis = computed(() => {
  return visiblePages.value.length > 0 && visiblePages.value[0] > 2
})

const showRightEllipsis = computed(() => {
  return visiblePages.value.length > 0 && visiblePages.value[visiblePages.value.length - 1] < totalPages.value - 1
})

// Méthodes
const goToPage = (page : number) => {
  if (page < 1 || page > totalPages.value || page === props.currentPage) {
    return
  }
  emit('page-change', page)
}
</script>