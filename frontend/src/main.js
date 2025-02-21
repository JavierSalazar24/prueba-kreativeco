import './assets/main.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'
import toast_plugin from './utils/toast_plugin'
import App from './App.vue'
import router from './router'
import { useLoginStore } from './stores/loginStore'

const app = createApp(App)

app.use(router)
app.use(toast_plugin)
app.use(createPinia())

const loginStore = useLoginStore()
loginStore.checkAuth()

app.mount('#app')
