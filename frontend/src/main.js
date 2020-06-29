import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'

import './assets/scss/app.scss'

import './registerServiceWorker'

Vue.config.productionTip = false

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')


// import Vue from 'vue'
// import App from './App.vue'
// import VueMaterial from 'vue-material'
// import './registerServiceWorker'
//
// Vue.use(VueMaterial)
//
// Vue.config.productionTip = false
//
// new Vue({
//     render: h => h(App),
// }).$mount('#app')
