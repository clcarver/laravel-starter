import Vue from 'vue'
import Buefy from 'buefy'
import store from '~/store'
import router from '~/router'
import App from '~/components/App'

import '~/plugins'
import '~/components'

Vue.config.productionTip = false

Vue.use(Buefy)

new Vue({
    store,
    router,
    ...App
})
