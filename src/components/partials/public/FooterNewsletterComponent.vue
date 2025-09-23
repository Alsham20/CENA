<template>
    <div class="bg-[#162233] mx-auto max-w-full">
        <div class="grid grid-cols-1 md:grid-cols-6 gap-4 mx-auto w-[90%] py-8 md:py-14">
            <div class="md:col-span-3">
                <div class="bg-[#162233] flex flex-col items-start justify-center space-y-8 shadow-3xl">
                    <!-- Titre -->
                    <div>
                        <h2 class="text-4xl xl:text-5xl font-extrabold text-white mb-2">La newsletter</h2>
                        <div
                            class="color-bar">
                        </div>
                    </div>
                    <p class="text-white font-normal text-lg lg:text-xl xl:text-3xl">
                        Recevez périodiquement l’essentiel de l’actualité de la CENA
                    </p>

                    <!-- Formulaire -->
                    <form class="space-y-6 w-full">
                        <!-- Nom + Prénom -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm xl:text-lg text-white font-semibold mb-1">Nom *</label>
                                <input type="text" placeholder="Requis"
                                    class="text-black w-full px-4 py-2 xl:py-4 outline-none" required />
                            </div>
                            <div>
                                <label class="text-sm xl:text-lg text-white font-semibold mb-1">Prénom *</label>
                                <input type="text" placeholder="Requis"
                                    class="text-black w-full px-4 py-2 xl:py-4 outline-none" required />
                            </div>
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="text-sm xl:text-lg text-white font-semibold mb-1">Email *</label>
                            <input type="email" placeholder="Requis"
                                class="text-black w-full px-4 py-2  xl:py-4 outline-none" required />
                        </div>

                        <!-- Bouton -->
                        <button type="submit"
                            class="text-sm xl:text-lg font-semibold hover:bg-white w-1/4 py-2 xl:py-4 hover:text-[#0E6258] border-b-2 hover:border-[#0E6258] bg-[#0E6258] border-[#F8F6F0] text-white ease-in duration-300 uppercase">
                            S'inscrire
                        </button>
                    </form>
                </div>
            </div>
            <div>

            </div>
            <div class="md:col-span-2">
                <CallCenter title="Call Center" subtitle="Une requête ?" description="Contactez notre centre d'appel"
                    phoneNumber="27 22 59 99 74" :showCallButton="true" />
            </div>
        </div>
    </div>
</template>
<script setup lang="ts">
import CallCenter from './CallCenter.vue';

const socialNetworks = [
    {
        name: 'Facebook',
        url: '#',
        icon: '/assets/img/socials/facebook.svg'
    },
    {
        name: 'Twitter',
        url: '#',
        icon: '/assets/img/socials/x.svg'
    },
    {
        name: 'YouTube',
        url: '#',
        icon: '/assets/img/socials/youtube.svg'
    },
    {
        name: 'Flickr',
        url: '#',
        icon: '/assets/img/socials/flickr.svg'
    },
]
</script>
<style scoped>
.color-bar {
    height: 5px;
    background: linear-gradient(to right, #006828 33.33%, #ffbe00 33.33% 66.66%, #ec0001 66.66%);
}
</style>