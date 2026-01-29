<script setup lang="ts">

import PaginationComponent from '@/components/partials/public/PaginationComponent.vue'
import { useDocumentStore } from '@/stores/document'
import { ref, computed, onMounted } from 'vue'
import { useFileSize } from '@/composables/useFileSize'
import { useFileType } from '@/composables/useFileType'
import { useFileDownload } from '@/composables/useFileDownload'
import DocumentPreview from '@/components/common/DocumentPreview.vue'

const documentStore = useDocumentStore()

// Computed properties for store state
const decisions = computed(() => documentStore.decisions)
const isLoading = computed(() => documentStore.loading)
const pagination = computed(() => documentStore.pagination)

// États des filtres
const keywordSearch = ref('')
const decisionType = ref('Tous les types')
const decisionNumber = ref('')
const requesterName = ref('')
const dateFrom = ref('')
const dateTo = ref('')

function formatDateFrancais(dateString?: string | null): string {
    if (!dateString) return ''

    const date = new Date(dateString.replace(' ', 'T'))

    return 'du ' + date.toLocaleDateString('fr-FR', {
        day: '2-digit',
        month: 'long',
        year: 'numeric'
    })
}


// Options pour le select
const decisionTypes = [
    'Tous les types',
    'Décisions ordinaires (DCC)',
    'Décisions électorales présidentielles (EP)',
    'Décisions électorales législatives (EL)',
    'Décisions électorales générales (EG)'
]

// Fonction de recherche
const handleSearch = () => {
    documentStore.fetchDecisions({
        page: 1,
        pageSize: 2,
        orderBy: 'date_creation',
        direction: 'desc',
        searchQuery: keywordSearch.value,
        category: decisionType.value,
        number: decisionNumber.value,
        requester: requesterName.value,
        from: dateFrom.value,
        to: dateTo.value
    })
    // Ici vous pouvez émettre un événement ou appeler une API
}
// Fetch documents on component mount
onMounted(() => {
    documentStore.fetchDecisions({
        page: 1,
        pageSize: 2,
        orderBy: 'date_creation',
        direction: 'desc',
        searchQuery: keywordSearch.value,
        category: decisionType.value,
        number: decisionNumber.value,
        requester: requesterName.value,
        from: dateFrom.value,
        to: dateTo.value
    })
})

const changePage = (page: number) => {
    documentStore.fetchDecisions({
        page,
        pageSize: 10,
        orderBy: 'date_creation',
        direction: 'desc',
        searchQuery: keywordSearch.value,
        category: decisionType.value,
        number: decisionNumber.value,
        requester: requesterName.value,
        from: dateFrom.value,
        to: dateTo.value
    })
}

const formatSize = (size: number) => {
    const { formatFileSize } = useFileSize()
    return formatFileSize(size)
}

const getType = (type: string) => {
    const { getFileType } = useFileType()
    return getFileType(type)
}

const handleDownload = (fileUrl: string, filename: string) => {
    const { downloadFile } = useFileDownload()
    downloadFile(fileUrl, filename)
}
</script>

<template>
    <div class=" bg-slate-100">
        <div class="container mx-auto px-4 py-12">
            <div class="flex flex-col lg:flex-row gap-8 items-start max-w-6xl mx-auto">
                <!-- Sidebar de recherche -->
                <aside class="w-full lg:w-4/12 flex-shrink-0">
                    <div class="bg-[#11845a] text-white shadow-lg p-6 sticky top-4">
                        <h2 class="text-2xl font-extrabold mb-6 uppercase">
                            Rechercher une décision
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
                                Type de décision
                            </label>
                            <select v-model="decisionType"
                                class="w-full px-4 py-2 text-gray-800 focus:outline-none appearance-none bg-white cursor-pointer">
                                <option v-for="type in decisionTypes" :key="type" :value="type">
                                    {{ type }}
                                </option>
                            </select>
                        </div>

                        <!-- Numéro de Décision -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium mb-2">
                                Numéro de Décision
                            </label>
                            <input v-model="decisionNumber" type="text" placeholder="Ex : DCC98-025 ou EP21-010..."
                                class="w-full px-4 py-2 text-gray-800 focus:outline-none" />
                        </div>

                        <!-- Requérant -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium mb-2">
                                Requérant
                            </label>
                            <input v-model="requesterName" type="text" placeholder="Tapez le nom du requérant ici..."
                                class="w-full px-4 py-2 text-gray-800 focus:outline-none" />
                        </div>

                        <!-- Entre le -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium mb-2">
                                Entre le : [ JJ-MM-AAAA ]
                            </label>
                            <input v-model="dateFrom" type="date" placeholder="exemple : 01-01-1995"
                                class="w-full px-4 py-2 text-gray-800 focus:outline-none" />
                        </div>

                        <!-- Et le -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium mb-2">
                                Et le : [ JJ-MM-AAAA ]
                            </label>
                            <input v-model="dateTo" type="date" placeholder="exemple : 31-12-2007"
                                class="w-full px-4 py-2 text-gray-800 focus:outline-none" />
                        </div>

                        <!-- Bouton rechercher -->
                        <button @click="handleSearch"
                            class="w-full bg-blue-900 text-white py-3 rounded font-semibold hover:bg-blue-800 transition-colors flex items-center justify-center gap-2">
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
                                Total : <span class="font-semibold">{{ pagination.total }} décisions</span>
                            </p>
                        </div>

                        <!-- Liste des décisions -->
                        <div class="mx-auto space-y-4">
                            <article v-for="decision in decisions" :key="decision.id"
                                class="bg-white shadow-xl p-6 hover:border-b-4 hover:border-[#2D3748] transition-all duration-300 cursor-pointer group">
                                <!-- En-tête avec icône et référence -->
                                <div class="flex items-start gap-3 mb-4">
                                    <div class="flex-shrink-0 text-gray-400 mt-1">
                                        <div class="text-xl xl:text-3xl">📄</div>

                                    </div>
                                    <h3
                                        class="text-lg font-bold text-gray-900 group-hover:text-blue-900 transition-colors">
                                        {{ decision.name.slice(0, 100) }}
                                        {{ decision.name.length > 100 ? '...' : '' }}
                                    </h3>
                                </div>

                                <!-- Détails de la décision -->
                                <div class="space-y-2 mb-4 ml-9">
                                    <p class="text-sm text-gray-700">
                                        <span class="font-semibold">Type de décision</span> : {{
                                            decision.categories.label }}
                                    </p>
                                    <p class="text-sm text-gray-700">
                                        <span class="font-semibold">Requérant</span> : {{ decision.requester }}
                                    </p>

                                    <p class="text-sm text-gray-700">
                                        <span class="font-semibold">Objet de la requête</span> :
                                        {{ decision.object.slice(0, 100) }}
                                        {{ decision.object.length > 100 ? '...' : '' }}
                                    </p>
                                </div>

                                <!-- Boutons d'action -->
                                <div class="flex gap-3 ml-9">
                                    <!-- <button @click="handleReadDecision(decision)"
                                        class="flex items-center justify-center gap-1 bg-[#2D3748] hover:bg-white text-white hover:text-[#2D3748] p-2 px-4 border-b border-[#2D3748] hover:border ease-in duration-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-bookmark-fill w-3 h-3" viewBox="0 0 16 16">
                                            <path
                                                d="M2 2v13.5a.5.5 0 0 0 .74.439L8 13.069l5.26 2.87A.5.5 0 0 0 14 15.5V2a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2" />
                                        </svg>
                                        Lire
                                    </button> -->
                                    <DocumentPreview :url="decision.doc_path" type="application/pdf" />

                                    <button @click="handleDownload(decision.doc_path, decision.name + '.pdf')"
                                        class="flex items-center justify-center gap-1 p-2 px-4 border-b border-white text-white hover:text-[#0E6258] bg-[#0E6258] hover:bg-white hover:border-[#0E6258] ease-in duration-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-download w-3 h-3" viewBox="0 0 16 16">
                                            <path
                                                d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5" />
                                            <path
                                                d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z" />
                                        </svg>
                                        Télécharger le PDF
                                    </button>
                                </div>
                            </article>
                        </div>
                        <div class="flex justify-center col-span-full">
                            <PaginationComponent :current-page="pagination.page" :total-items="pagination.total"
                                :items-per-page="10" :max-visible-pages="5" @page-change="changePage" />
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
</template>