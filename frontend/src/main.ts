import Vue from 'vue'
import App from './App.vue'
import router from './router/router'
import store from './store/store'

import VueFormulate from '@braid/vue-formulate'

import api from './api/api'

import './assets/scss/app.scss'

import './registerServiceWorker'

Vue.config.productionTip = false
Vue.$api = api;
Object.defineProperty(Vue.prototype, '$api', {
    get() {
        return api
    }
})

Vue.use(VueFormulate)

new Vue({
    router,
    store,
    render: h => h(App)
}).$mount('#app')
