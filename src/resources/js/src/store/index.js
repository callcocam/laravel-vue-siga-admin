/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

import Vue from 'vue'
import Vuex from 'vuex'

import state from "@store/modules/state"
import getters from "@store/modules/getters"
import mutations from "@store/modules/mutations"
import actions from "@store/modules/actions"

Vue.use(Vuex)

export default new Vuex.Store({
    getters,
    mutations,
    state,
    actions,
    modules:{

    },
    strict:false
})
