import './assets/main.css'
import './style.css'
import { createApp } from 'vue'
import { createPinia } from 'pinia'
import App from './App.vue'
import router from './router'
import 'aos/dist/aos.css'
// eslint-disable-next-line @typescript-eslint/ban-ts-comment
// @ts-ignore
import AOS from 'aos'


const app = createApp(App)

app.use(createPinia())
app.use(router)
// eslint-disable-next-line @typescript-eslint/ban-ts-comment
// @ts-ignore
app.use(AOS)

app.mount('#app')
