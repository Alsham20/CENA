<script setup lang="ts">
import { computed, onMounted, ref } from 'vue'
import { useElectionStore } from '@/stores/election'
import type { TResultat } from '@/requests/election'
import PaginationComponent from '@/components/partials/public/PaginationComponent.vue'
import { useFileType } from '@/composables/useFileType'

const { getFileType } = useFileType()
const keywordSearch = ref('')
const electionType = ref('')
const electionYear = ref('')

// Options pour le select
const electionTypes = [
  { key: 'Tous les types', value: '' },
  { key: 'Présidentielle', value: 'Présidentielle' },
  { key: 'Legislative', value: 'Législative' },
  { key: 'Communale', value: 'Communale' }
]

const electionYears = [
  { key: 'Toutes les années', value: '' },
  { key: '2021', value: '2021' },
  { key: '2023', value: '2023' },
  { key: '2026', value: '2026' }
]

const electionStore = useElectionStore()

// Computed properties for store state
const elections = computed(() => electionStore.elections)
const isLoading = computed(() => electionStore.loading)
const pagination = computed(() => electionStore.pagination)

// Fonction de recherche
const handleSearch = () => {
  electionStore.listElections({
    page: 1,
    pageSize: 10,
    orderBy: 'date_election',
    orderDirection: 'desc',
    search: keywordSearch.value,
    category: electionType.value,
    year: electionYear.value
  })
  // Ici vous pouvez émettre un événement ou appeler une API
}
// Fetch documents on component mount
onMounted(() => {
  electionStore.listElections({
    page: 1,
    pageSize: 10,
    orderBy: 'date_election',
    orderDirection: 'desc',
    search: keywordSearch.value,
    category: electionType.value,
    year: electionYear.value
  })
})

const changePage = (page: number) => {
  electionStore.listElections({
    page,
    pageSize: 10,
    orderBy: 'date_election',
    orderDirection: 'desc',
    search: keywordSearch.value,
    category: electionType.value,
    year: electionYear.value
  })
}

// État pour l'accordion ouvert
const openAccordionId = ref<number | null>(null)

// Toggle accordion
const toggleAccordion = (electionId: number) => {
  if (openAccordionId.value === electionId) {
    openAccordionId.value = null
  } else {
    openAccordionId.value = electionId
  }
}

// Télécharger un résultat (ouvre le lien Google Drive)
const downloadResult = (result: TResultat) => {
  window.open(result.url, '_blank')
}

// Formater la date
const formatDate = (dateString: string) => {
  const date = new Date(dateString)
  return date.toLocaleDateString('fr-FR', {
    day: '2-digit',
    month: 'long',
    year: 'numeric'
  })
}
</script>

<template>
  <div class="bg-slate-100">
    <div class="container mx-auto px-4 py-12">
      <!-- En-tête -->
      <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-[#0E6258] mb-4">
          RÉSULTATS DES ÉLECTIONS
        </h1>
        <p class="text-gray-600 text-lg">
          Consultez et téléchargez les résultats officiels des différentes élections
        </p>
      </div>

      <div class="flex flex-col lg:flex-row gap-8 items-start max-w-6xl mx-auto">
        <!-- Sidebar de recherche -->
        <aside class="w-full lg:w-4/12 flex-shrink-0">
          <div class="bg-[#11845a] text-white shadow-lg p-6 sticky top-4">
            <h2 class="text-2xl font-extrabold mb-6 uppercase">
              Rechercher une élection
            </h2>

            <!-- Mots clés -->
            <div class="mb-6">
              <label class="block text-sm font-medium mb-2">
                Mots clés
              </label>
              <input v-model="keywordSearch" type="text" placeholder="Écrivez un ou des mots clés ici..."
                class="w-full px-4 py-2 text-gray-800 focus:outline-none" />
            </div>

            <!-- Type de décision -->
            <div class="mb-6">
              <label class="block text-sm font-medium mb-2">
                Type d'élection
              </label>
              <select v-model="electionType"
                class="w-full px-4 py-2 text-gray-800 focus:outline-none appearance-none bg-white cursor-pointer">
                <option v-for="type in electionTypes" :key="type.key" :value="type.value">
                  {{ type.key }}
                </option>
              </select>
            </div>

            <!-- Année-->
            <div class="mb-6">
              <label class="block text-sm font-medium mb-2">
                Année
              </label>
              <select v-model="electionYear"
                class="w-full px-4 py-2 text-gray-800 focus:outline-none appearance-none bg-white cursor-pointer">
                <option v-for="year in electionYears" :key="year.key" :value="year.value">
                  {{ year.key }}
                </option>
              </select>
            </div>

            <!-- Bouton rechercher -->
            <button @click="handleSearch"
              class="w-full bg-blue-900 text-white py-3 font-semibold hover:bg-blue-800 transition-colors flex items-center justify-center gap-2">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
              RECHERCHER
            </button>
          </div>
        </aside>

        <!-- Liste des résultats -->
        <main class="lg:w-8/12 flex flex-col justify-center">
          <div v-if="isLoading" class="flex justify-center items-center py-8">
            <div class="loader"></div>
          </div>
          <div v-else>
            <!-- En-tête des résultats -->
            <div class="mb-2">
              <p class="text-gray-600">
                Total : <span class="font-semibold">{{ pagination.total }} élections</span>
              </p>
            </div>
            <!-- Liste des résultats -->
            <div class="mx-auto space-y-4">
              <div v-for="election in elections" :key="election.id"
                class="bg-white shadow-md overflow-hidden transition-all duration-300"
                :class="{ 'shadow-xl bg-[#11845a]': openAccordionId === election.id }">
                <!-- En-tête de l'accordion -->
                <button @click="toggleAccordion(election.id)"
                  class="group w-full px-6 py-5 flex items-center justify-between hover:bg-[#11845a]/10 focus:bg-[#11845a] border-b-2 border-[#11845a] transition-colors"
                  :class="{ 'border-b-2 border-yellow-400 bg-[#11845a]': openAccordionId === election.id }">
                  <div class="flex items-center gap-4 flex-1 text-left">
                    <!-- Badges -->
                    <div class="flex flex-col sm:flex-row gap-2">
                      <span class="bg-red-500 text-white px-4 py-1.5 text-sm font-semibold whitespace-nowrap">
                        {{ election.categories.label }}
                      </span>
                      <span class="bg-yellow-400 text-white px-4 py-1.5 text-sm font-bold">
                        {{ election.year }}
                      </span>
                    </div>

                    <!-- Titre et description -->
                    <div class="flex-1 min-w-0 text-[#2D3748] group-hover:text-[#11845a] group-focus:text-white"
                      :class="{ 'text-white': openAccordionId === election.id }">
                      <h3 class="text-lg font-bold mb-1">
                        {{ election.title }}
                      </h3>
                      <p class="text-sm line-clamp-1" v-html="election.description">
                      </p>
                    </div>

                    <!-- Compteur de résultats -->
                    <div class="hidden md:flex items-center gap-2 text-red-600 bg-red-100 px-4 py-2">
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                      </svg>
                      <span class="text-sm font-semibold">
                        {{ election.resultats.length }}
                      </span>
                    </div>
                  </div>

                  <!-- Icône chevron -->
                  <div class="ml-4 flex-shrink-0">
                    <svg
                      class="w-6 h-6 text-[#2D3748] group-hover:text-[#11845a] group-focus:text-white transition-transform duration-300"
                      :class="{ 'rotate-180 text-white': openAccordionId === election.id }" fill="none"
                      stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                  </div>
                </button>

                <!-- Contenu de l'accordion -->
                <div v-show="openAccordionId === election.id" class="border-t border-gray-200">
                  <div class="p-6 bg-gradient-to-br from-gray-50 to-white">
                    <!-- Titre de la section résultats -->
                    <div class="flex items-center gap-2 mb-4 pb-3 border-b border-gray-300">
                      <svg class="w-5 h-5 text-[#11845a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                      </svg>
                      <h4 class="text-lg font-bold text-gray-800">
                        Résultats disponibles ({{ election.resultats.length }})
                      </h4>
                    </div>

                    <!-- Liste des résultats -->
                    <div class="space-y-3">
                      <div v-for="result in election.resultats" :key="result.id"
                        class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 p-4 bg-white hover:bg-gray-50 transition-all duration-200 border border-gray-200 hover:border-yellow-400 hover:shadow-md group">
                        <div class="flex items-center gap-4 flex-1 min-w-0">
                          <!-- Icône PDF -->
                          <div class="w-12 h-12 bg-red-100  flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                              <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z" />
                              <path d="M14 2v6h6M10 13h4M10 17h4" />
                            </svg>
                          </div>

                          <!-- Infos du résultat -->
                          <div class="flex-1 min-w-0">
                            <h5 class="font-semibold text-gray-900 group-hover:text-[#11845a] transition-colors mb-1">
                              {{ result.title }}
                            </h5>
                            <div class="flex flex-wrap items-center gap-3 text-sm text-gray-600">
                              <span class="bg-red-100 text-red-700 px-2 py-0.5 text-xs font-semibold rounded">
                                {{ getFileType(result.url) }}
                              </span>
                              <span v-if="result.zone" class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                {{ result.zone }}
                              </span>
                              <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ result.date_resultat && formatDate(result.date_resultat) }}
                              </span>
                            </div>
                          </div>
                        </div>

                        <!-- Bouton télécharger -->
                        <button @click="downloadResult(result)"
                          class="bg-[#11845a] text-white px-6 py-2 font-medium hover:bg-[#0E6258] transition-all duration-200 flex items-center justify-center gap-2 shadow-md hover:shadow-lg whitespace-nowrap">
                          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                          </svg>
                          Télécharger
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="flex justify-center col-span-full">
              <PaginationComponent :current-page="pagination.page" :total-items="pagination.total" :items-per-page="10"
                :max-visible-pages="5" @page-change="changePage" />
            </div>
          </div>
        </main>
      </div>
    </div>
  </div>
</template>

<style scoped>
.line-clamp-1 {
  display: -webkit-box;
  -webkit-line-clamp: 1;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>