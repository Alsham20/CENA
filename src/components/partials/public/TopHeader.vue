<template>
    <div class="bg-[#0E6258] text-white py-2">
        <div class="mx-auto w-[95%] max-w-[1200px] flex items-center justify-between">
            <!-- Informations de contact -->
            <div class="flex items-center space-x-6 text-xs">
                <!-- Téléphone -->
                <div class="flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                    </svg>
                    <span>{{ contactInfo.phone }}</span>
                </div>

                <!-- Email -->
                <div class="flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                    </svg>
                    <span>{{ contactInfo.email }}</span>
                </div>

                <!-- Adresse -->
                <div class="flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                            clip-rule="evenodd" />
                    </svg>
                    <span>{{ contactInfo.address }}</span>
                </div>
            </div>

            <!-- Barre de recherche et réseaux sociaux -->
            <div class="flex items-center space-x-4">
                <!-- Barre de recherche -->
                <div class="relative">
                    <input v-model="searchQuery" type="text"
                        class="bg-white text-gray-800 px-4 py-2 pr-10 rounded-full text-xs focus:outline-none w-64"
                        @keyup.enter="handleSearch" />
                    <button @click="handleSearch"
                        class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-[#EC0001] hover:bg-[#0E6258] text-white p-2 rounded-e-full transition-colors h-full">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import AppleIcon from '@/components/icons/AppleIcon.vue'
import FacebookIcon from '@/components/icons/FacebookIcon.vue'
import PlayIcon from '@/components/icons/PlayIcon.vue'
import TwitterIcon from '@/components/icons/TwitterIcon.vue'
import YoutubeIcon from '@/components/icons/YoutubeIcon.vue'
import { ref, reactive } from 'vue'

// État réactif pour la recherche
const searchQuery = ref('')

// Informations de contact
const contactInfo = reactive({
    phone: '+229 01 21 31 41 24',
    email: 'cena.support@cena.bj',
    address: 'Rue 866, Cotonou, Bénin'
})

// Fonction de recherche
const handleSearch = () => {
    if (searchQuery.value.trim()) {
        console.log('Recherche:', searchQuery.value)
        // Ici tu peux ajouter ta logique de recherche
        // Par exemple: router.push(`/search?q=${searchQuery.value}`)
    }
}
</script>

<style scoped>
/* Styles personnalisés si nécessaire */
</style>