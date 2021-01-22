import Vue from 'vue'
import App from './App.vue'
import router from './router/router'
import store from './store/store'

/* eslint-disable */
// @ts-ignore
import VueFormulate from '@braid/vue-formulate'

import api from './api/api'

import './assets/scss/app.scss'

import './registerServiceWorker.ts'

Vue.config.productionTip = false
// @ts-ignore
Vue.$api = api;
/* eslint-enable */

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
