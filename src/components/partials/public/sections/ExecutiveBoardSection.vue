<script setup lang="ts">
import { ref } from 'vue'
import MemberCard from '../cards/MemberCard.vue';
import { members } from '@/data';

// État pour le modal de biographie
const isModalOpen = ref(false)
const selectedMember = ref<Member | null>(null)

// Gestion des événements
const handleViewBiography = (member: Member) => {
    selectedMember.value = member
    isModalOpen.value = true
    document.body.style.overflow = 'hidden'
}

const closeModal = () => {
    isModalOpen.value = false
    selectedMember.value = null
    document.body.style.overflow = 'auto'
}

const handleSocialLink = (url: string, platform: string) => {
    
}

const handleViewAll = () => {
    // Logique pour voir tous les membres
    console.log('Voir tout le bureau')
}
</script>

<template>
    <section class="py-4 md:py-8 m-auto w-[90%] space-y-4 md:space-y-10">
        <div class="flex justify-between items-center">
            <h1 class="text-[#0E6258] text-xl md:text-3xl xl:text-5xl font-extrabold">Le Conseil Electoral </h1>
            <!-- <div class="flex items-center space-x-2 text-center">
                <span class="text-blue-900 md:text-lg font-medium invisible md:visible">Tout le conseil</span>
                <router-link to="/membres" class="p-2 rounded-full bg-blue-900 hover:bg-blue-700 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.5c-4.99 0-9.27 3.11-11 7.5 1.73 4.39 6.01 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6.01-7.5-11-7.5z" />
                        <circle cx="12" cy="12" r="3" stroke-width="2" />
                    </svg>
                </router-link>
            </div> -->
        </div>

        <!-- Grille des membres -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-24 pt-12">
            <MemberCard v-for="member in members" :key="member.id" :member="member"
                @view-biography="handleViewBiography" @open-social-link="handleSocialLink" />
            <!-- <div
                class="hidden md:block relative bg-white rounded-lg shadow-lg overflow-visible pb-6 px-6 border-b-4 border-[#11845a]">
                <div class="w-64 h-48 m-auto">
                    <img src="/assets/img/images-removebg-preview.png" class="w-full h-auto object-contain" />
                </div>
            </div> -->
        </div>

        <!-- Modal de biographie -->
        <Teleport to="body">
            <div v-if="isModalOpen && selectedMember"
                class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-75" @click="closeModal">
                <!-- Contenu du modal -->
                <div class="bg-white rounded-lg max-w-2xl max-h-[80vh] overflow-y-auto m-4 p-6" @click.stop>
                    <!-- En-tête du modal -->
                    <div class="flex justify-between items-start mb-6">
                        <div class="flex items-center gap-4">
                            <img :src="selectedMember.avatarUrl"
                                :alt="`${selectedMember.firstName} ${selectedMember.lastName}`"
                                class="w-16 h-16 rounded-lg object-cover" />
                            <div>
                                <h3 class="text-xl font-bold text-blue-900">
                                    {{ selectedMember.firstName }} {{ selectedMember.lastName }}
                                </h3>
                                <p class="text-gray-600">{{ selectedMember.position }}</p>
                            </div>
                        </div>

                        <button @click="closeModal"
                            class="w-8 h-8 flex items-center justify-center text-gray-500 hover:text-gray-700 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Contenu de la biographie -->
                    <div class="prose max-w-none">
                        <p class="text-gray-700 leading-relaxed">
                            Biographie de {{ selectedMember.firstName }} {{ selectedMember.lastName }}...
                        </p>
                        <p class="text-gray-700 leading-relaxed mt-4">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut
                            labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                            laboris nisi ut aliquip ex ea commodo consequat.
                        </p>
                        <p class="text-gray-700 leading-relaxed mt-4">
                            Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
                            pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt
                            mollit anim id est laborum.
                        </p>
                    </div>

                    <!-- Réseaux sociaux dans le modal -->
                    <div v-if="selectedMember.socialLinks" class="mt-6 pt-4 border-t">
                        <p class="text-sm font-medium text-gray-600 mb-3">Suivez-nous :</p>
                        <div class="flex gap-3">
                            <button v-if="selectedMember.socialLinks.facebook"
                                @click="handleSocialLink(selectedMember.socialLinks.facebook, 'facebook')"
                                class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center hover:bg-blue-700 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                </svg>
                            </button>

                            <button v-if="selectedMember.socialLinks.twitter"
                                @click="handleSocialLink(selectedMember.socialLinks.twitter, 'twitter')"
                                class="w-10 h-10 bg-blue-400 text-white rounded-full flex items-center justify-center hover:bg-blue-500 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                                </svg>
                            </button>

                            <button v-if="selectedMember.socialLinks.linkedin"
                                @click="handleSocialLink(selectedMember.socialLinks.linkedin, 'linkedin')"
                                class="w-10 h-10 bg-blue-700 text-white rounded-full flex items-center justify-center hover:bg-blue-800 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </Teleport>
    </section>
</template>