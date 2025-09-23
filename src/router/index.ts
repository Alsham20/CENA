import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/public/HomeView.vue'
import PublicLayout from '@/layouts/PublicLayout.vue'
import BureauView from '@/views/public/BureauView.vue'
import PresentationView from '@/views/public/PresentationView.vue'
import MissionView from '@/views/public/MissionView.vue'
import FonctionnementView from '@/views/public/FonctionnementView.vue'
import AOS from 'aos'

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
        path: '/presentation-de-la-cena',
        name: 'Presentation de la cena',
        component: PresentationView,
        meta: { title: 'Présentation de la CENA | CENA' },
      },
      {
        path: '/missions-de-la-cena',
        name: 'Missions de la cena',
        component: MissionView,
        meta: { title: 'Les missions de la CENA | CENA' },
      },
      {
        path: '/fonctionnement-de-la-cena',
        name: 'Fonctionnement de la cena',
        component: FonctionnementView,
        meta: { title: 'Fonctionnement de la CENA | CENA' },
      },
      {
        path: '/bureau',
        name: 'Bureau',
        component: BureauView,
        meta: { title: 'Bureau | CENA' },
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
