
require('./bootstrap');

window.Vue = require('vue');

import "@/globalconfig"

// i18n
import i18n from '@/plugins/i18n/i18n'

// Globally Registered Components
import '@/globalComponents.js'

import App from '@/App'
// Vuex Store
import store from '@store'


import router from './src/router'


Vue.config.productionTip = false

new Vue({
    router,
    store,
    i18n,
    render: h => h(App)
}).$mount('#app')
