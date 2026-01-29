import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/public/HomeView.vue'
import PublicLayout from '@/layouts/PublicLayout.vue'
import AOS from 'aos'
import ActualitesView from '@/views/public/actualite/ActualitesView.vue'
import ArticleView from '@/views/public/actualite/ArticleView.vue'
import SearchView from '@/views/public/actualite/SearchView.vue'
import PageView from '@/views/public/page/PageView.vue'
import NotFoundView from '@/views/NotFoundView.vue'
import ComingSoonView from '@/views/ComingSoonView.vue'
import PresentationOfCenaView from '@/views/public/PresentationOfCenaView.vue'
import MissionsOfCenaView from '@/views/public/MissionsOfCenaView.vue'
import GeneralDirectorateOfElectionsView from '@/views/public/GeneralDirectorateOfElectionsView.vue'
import ElectoralCouncilView from '@/views/public/ElectoralCouncilView.vue'
import PresidentView from '@/views/public/PresidentView.vue'
import CouncilDecisionsView from '@/views/public/resources/CouncilDecisionsView.vue'
import TextsAndLawsView from '@/views/public/resources/TextsAndLawsView.vue'
import ElectionResultsView from '@/views/public/resources/ElectionResultsView.vue'
import DigitalPlatformsView from '@/views/public/resources/DigitalPlatformsView.vue'
import CallCenterView from '@/views/public/contact/CallCenterView.vue'
import TechnicalSupportView from '@/views/public/contact/TechnicalSupportView.vue'
import VideosView from '@/views/public/videos/VideosView.vue'

const routes = [
  {
    path: '/',
    component: PublicLayout,
    children: [
      {
        path: '',
        name: 'ACCUEIL',
        component: HomeView,
        meta: { title: 'Commission Électorale Nationale Autonome | CENA' },
      },
      {
        path: '/actualites',
        name: 'Actualités',
        component: ActualitesView,
        meta: { title: 'Actualités | CENA' },
      },
            {
        path: '/videos',
        name: 'Vidéos',
        component: VideosView,
        meta: { title: 'Vidéothèque | CENA' },
      },
      {
        path: '/articles/:id',
        name: 'Actualités details',
        component: ArticleView,
        props: true,
        meta: { title: 'Actualités | CENA' },
      },
      {
        path: 'rechercher/actualites',
        name: 'Actualités recherche',
        component: SearchView,
        meta: { title: 'Recherche | CENA' },
      },
      {
        path: '/page/:slug',
        name: 'Page Details',
        component: PageView,
        meta: { title: 'Pages | CENA' },
      },
      {
        path: '/404',
        name: 'NotFound',
        component: NotFoundView,
        meta: { title: 'Page Not Found | CENA' },
      },
      {
        path: '/bientot-disponible',
        name: 'Bientôt disponible',
        component: ComingSoonView,
        meta: { title: 'Bientôt disponible | CENA' },
      },
      {
        path: '/presentation-de-la-cena',
        name: 'Presentation de la cena',
        component: PresentationOfCenaView,
        meta: { title: 'Présentation de la CENA | CENA' },
      },
      {
        path: '/missions-de-la-cena',
        name: 'Missions de la cena',
        component: MissionsOfCenaView,
        meta: { title: 'Les missions de la CENA | CENA' },
      },
      {
        path: '/president',
        name: 'Président',
        component: PresidentView,
        meta: { title: 'Président | CENA' },
      },
      {
        path: '/conseil-electoral',
        name: 'Conseil électoral',
        component: ElectoralCouncilView,
        meta: { title: 'Conseil électoral | CENA' },
      },
      {
        path: '/direction-generale-des-elections',
        name: 'Direction générale des élections',
        component: GeneralDirectorateOfElectionsView,
        meta: { title: 'Direction générale des élections | CENA' },
      },
      {
        path: '/ressources/decisions-du-conseil',
        name: 'Décisions du conseil',
        component: CouncilDecisionsView,
        meta: { title: 'Décisions du conseil | CENA' },
      },
      {
        path: '/ressources/textes-et-lois',
        name: 'Textes et lois',
        component: TextsAndLawsView,
        meta: { title: 'Textes et lois | CENA' },
      },
      {
        path: '/ressources/resultats-electoraux',
        name: 'Résultats électoraux',
        component: ElectionResultsView,
        meta: { title: 'Résultats électoraux | CENA' },
      },
      {
        path: '/ressources/digital-platforms',
        name: 'Services en ligne',
        component: DigitalPlatformsView,
        meta: { title: 'Services en ligne| CENA' },
      },
      {
        path: '/centre-appel',
        name: 'Centre d\'appel',
        component: CallCenterView,
        meta: { title: 'Centre d\'appel | CENA' },
      },
      {
        path: '/support-technique',
        name: 'Support technique',
        component: TechnicalSupportView,
        meta: { title: 'Support technique | CENA' },
      },
      {
        path: '/:pathMatch(.*)*',
        redirect: '/bientot-disponible',
      },
    ],
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior(to, from, savedPosition) {
    return { top: 0 };
  },
})

router.beforeEach(async (to, from, next) => {
  AOS.init() // Initialize AOS
  next()
})

export default router
