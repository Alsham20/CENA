<template>
    <footer class="bg-[#162233] mx-auto max-w-full">
        <div class="color-bar w-full"></div>
        <div
            class="m-auto w-[90%] text-white text-sm grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 py-10 space-x-0 gap-6 md:space-x-6">
            <div class="flex flex-col space-y-2 text-xs xl:text-lg">
                <h3 class="font-bold uppercase">L'ORGANISATION</h3>
                <ul class="list-disc list-inside leading-5">
                    <li v-for="item in organizationLinks" :key="item.title">
                        <router-link :to="item.link">{{ item.title }}</router-link>
                    </li>
                </ul>
            </div>
            <div class="flex flex-col space-y-2 text-xs xl:text-lg">
                <h3 class="font-bold uppercase">LE VOTE</h3>
                <ul class="list-disc list-inside leading-5">
                    <li v-for="item in voteLinks" :key="item.title">
                        <router-link :to="item.link">{{ item.title }}</router-link>
                    </li>
                </ul>
            </div>
            <div class="flex flex-col space-y-3 text-xs xl:text-lg">
                <div class="space-y-2">
                    <h3 class="font-bold uppercase">LES ÉLÉCTIONS</h3>
                    <ul class="list-disc list-inside leading-5">
                        <li v-for="item in electionLinks" :key="item.title">
                            <router-link :to="item.link">{{ item.title }}</router-link>
                        </li>
                    </ul>
                </div>
                <div class="space-y-2">
                    <h3 class="font-bold uppercase">L'ACTUALITÉ</h3>
                    <ul class="list-disc list-inside leading-5">
                        <li v-for="item in newsLinks" :key="item.title">
                            <router-link :to="item.link">{{ item.title }}</router-link>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="flex flex-col space-y-2 text-xs xl:text-lg">
                <h3 class="font-bold uppercase">RESSOURCES</h3>
                <ul class="list-disc list-inside leading-5">
                    <li v-for="item in resourceLinks" :key="item.title">
                        <router-link :to="item.link">{{ item.title }}</router-link>
                    </li>
                </ul>
            </div>
            <div class="flex flex-col space-y-2 text-xs xl:text-lg">
                <h3 class="font-bold uppercase">MEDIA CENTER</h3>
                <ul class="list-disc list-inside leading-5">
                    <li v-for="item in mediaLinks" :key="item.title">
                        <router-link :to="item.link">{{ item.title }}</router-link>
                    </li>
                </ul>
            </div>
            <div class="flex flex-col space-y-2 text-xs xl:text-lg">
                <h3 class="font-bold uppercase">LIENS UTILES</h3>
                <ul class="list-disc list-inside leading-5">
                    <li v-for="item in utilLinks" :key="item.title">
                        <router-link :to="item.link">{{ item.title }}</router-link>
                    </li>
                </ul>
            </div>
        </div>
        <div
            class="border-t border-[#1880E7]">
            <div class="m-auto w-[90%] flex flex-row items-center justify-between text-sm space-y-2 py-4 text-white">
                <div class="font-semibold">© CENA Bénin - 2024</div>
                <div class="font-semibold">Mentions légales et gestions des cookies</div>
            </div>
        </div>
    </footer>
</template>
<script setup lang="ts">

const organizationLinks = [
    { link: '/#', title: 'Présentation de la CENA' },
    { link: '/#', title: 'Les missions de la CENA' },
    { link: '/#', title: 'Fonctionnement de la CENA' },
    { link: '/#', title: 'Le bureau' },
]

const voteLinks = [
    { link: '/#', title: 'Comment voter ?' },
    { link: '/#', title: 'Le système éléctorale' },
    { link: '/#', title: 'Lexiques des élections' },
    { link: '/#', title: 'Abréviations et termes techniques' },
]

const electionLinks = [
    { link: '/#', title: 'Résultats récents', src: '/src/assets/partners/oms.png' },
    { link: '/#', title: 'Statistiques', src: '/src/assets/partners/unfpa.png' },
]

const newsLinks = [
    { link: '/#', title: 'Actualité' },
    { link: '/#', title: 'Communiqués' },
]
const resourceLinks = [
    { link: '/#', title: 'Documents' },
    { link: '/#', title: 'Textes de loi' },
    { link: '/#', title: 'Archives' },
    { link: '/#', title: 'Archives' },
]

const mediaLinks = [
    { link: '/#', title: 'Centre des Médias et de l\'Information Électorale' },
    { link: '/#', title: 'Accréditations' },
    { link: '/#', title: 'Actualité' },
    { link: '/#', title: 'Communiqués' },
]


const utilLinks = [
    { link: '/#', title: 'Gouvernement du Bénin' },
    { link: '/#', title: 'Cour Constitutionnelle' },
    { link: '/#', title: 'Cour Suprême' },
]
</script>
<style scoped>
.color-bar {
    height: 10px;
    background: linear-gradient(to right, #006828 33.33%, #ffbe00 33.33% 66.66%, #ec0001 66.66%);
}
</style>