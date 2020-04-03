/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

export  default {
    SET_BEARER(state, accessToken) {
        window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + accessToken
    },

    UPDATE_USER_INFO( state, payload ){

        state.userInfo =  JSON.stringify(payload)

    },
    SET_USER_INFO( state, payload ){

        state.userInfo = payload

        // Store data in localStorage
        localStorage.setItem("userInfo", JSON.stringify(payload))


    },

    SET_MENUS( state, payload ){

        state.menus = payload

    },

    SET_IS_ROUTES( state, payload ){

        state.menus = payload

    },

    SET_USER( state, payload ){

        state.user = payload

    },

    SET_ALL( state, payload){

        state.rows = payload.rows

    },

    SET_FIND( state, payload ){

        state.rows = payload.rows

    },

    SET_HEADER( state, payload ){

        state.headers = payload.headers

    },

    SET_OPTIONS( state, payload ){

        state.options = payload.options

    }
}
