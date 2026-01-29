<template>
    <footer class="bg-[#162233] mx-auto max-w-full">
        <div class="color-bar w-full"></div>
        <div
            class="m-auto w-[90%] text-white text-sm grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 py-10 space-x-0 gap-6 md:space-x-6">
            <div class="flex flex-col space-y-2 text-xs xl:text-sm">
                <h3 class="font-bold uppercase">ORGANISATION</h3>
                <ul class="list-none list-inside leading-5 space-y-1">
                    <li v-for="item in organizationLinks" :key="item.title">
                        <router-link :to="item.link">{{ item.title }}</router-link>
                    </li>
                </ul>
            </div>
            <div class="flex flex-col space-y-2 text-xs xl:text-sm">
                <h3 class="font-bold uppercase">ELECTEUR</h3>
                <ul class="list-none list-inside leading-5 space-y-1">
                    <li v-for="item in voteLinks" :key="item.title">
                        <router-link :to="item.link">{{ item.title }}</router-link>
                    </li>
                </ul>
            </div>
            <div class="flex flex-col space-y-3 text-xs xl:text-sm">
                <div class="space-y-2">
                    <h3 class="font-bold uppercase">ELECTIONS</h3>
                    <ul class="list-inside list-none leading-5 space-y-1">
                        <li v-for="item in electionLinks" :key="item.title">
                            <router-link :to="item.link">{{ item.title }}</router-link>
                        </li>
                    </ul>
                </div>
                <!-- <div class="space-y-2">
                    <h3 class="font-bold uppercase">L'ACTUALITÉ</h3>
                    <ul class="list-none list-inside leading-5 space-y-1">
                        <li v-for="item in newsLinks" :key="item.title">
                            <router-link :to="item.link">{{ item.title }}</router-link>
                        </li>
                    </ul>
                </div> -->
            </div>
            <div class="flex flex-col space-y-2 text-xs xl:text-sm">
                <h3 class="font-bold uppercase">RESSOURCES</h3>
                <ul class="list-none list-inside leading-5 space-y-1">
                    <li v-for="item in resourceLinks" :key="item.title">
                        <router-link :to="item.link">{{ item.title }}</router-link>
                    </li>
                </ul>
            </div>
            <div class="flex flex-col space-y-2 text-xs xl:text-sm">
                <h3 class="font-bold uppercase">MEDIA CENTER</h3>
                <ul class="list-none list-insideleading-5 space-y-1">
                    <li v-for="item in mediaLinks" :key="item.title">
                        <router-link :to="item.link">{{ item.title }}</router-link>
                    </li>
                </ul>
            </div>
            <div class="flex flex-col space-y-2 text-xs xl:text-sm">
                <h3 class="font-bold uppercase">SUIVEZ NOUS</h3>
                <div class="hidden lg:flex items-start space-x-1 rounded-full py-1">
                    <a v-for="social in socialLinks" :key="social.name" :href="social.url" target="_blank"
                        rel="noopener noreferrer"
                        class="bg-[white] bg-opacity-0 pe-2 rounded-full transition-all duration-200 hover:scale-110"
                        :title="social.name">
                        <component :is="social.icon" class="w-5 h-5" />
                    </a>
                </div>
            </div>
        </div>
        <div class="border-t border-[#1880E7]">
            <div class="m-auto w-[90%] flex flex-row items-center justify-between text-sm space-y-2 py-4 text-white">
                <div class="font-semibold">© CENA Bénin - 2024</div>
                <div class="font-semibold">Mentions légales et gestions des cookies</div>
            </div>
        </div>
    </footer>
</template>
<script setup lang="ts">
import AppleIcon from '@/components/icons/AppleIcon.vue';
import PlayIcon from '@/components/icons/PlayIcon.vue';
import FacebookIcon from '@/components/icons/FacebookIcon.vue';
import TwitterIcon from '@/components/icons/TwitterIcon.vue';
import YoutubeIcon from '@/components/icons/YoutubeIcon.vue';
import { shallowRef } from 'vue';

const organizationLinks = [
    { link: '/presentation-de-la-cena', title: 'Présentation' },
]

const voteLinks = [
    { link: '/who-can-vote', title: 'Qui peux être électeur ?' },
    { link: '/polling-station', title: 'Mon centre de vôte' },
    { link: '/electoral-list ', title: 'La liste électorale (LEI)' },
]

const electionLinks = [
    { link: '/recent-results', title: 'Résultats récents' },
    { link: '/election-results', title: 'Résultats électoraux' },
    { link: '/organization-accreditations', title: 'Acrédidations des organismes' },
]

const resourceLinks = [
    { link: '/ressources/decisions-du-conseil', title: 'Décisions du conseil' },
    { link: '/ressources/textes-et-lois', title: 'Textes de loi' },
    { link: '/ressources/resultats-electoraux', title: 'Résultats électoraux' },
    { link: '/ressources/digital-platforms', title: 'Services en ligne'}
]

const mediaLinks = [
    { link: '/gallery', title: 'Galleries' }
]



// Liens des réseaux sociaux
const socialLinks = shallowRef([
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

</script>
<style scoped>
.color-bar {
    height: 10px;
    background: linear-gradient(to right, #006828 33.33%, #ffbe00 33.33% 66.66%, #ec0001 66.66%);
}
</style>