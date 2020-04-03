/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

export  default {

    isAddRoutes: state=>{

        return state.isAddRoutes

    },

    userInfo: state=>{

        return state.userInfo

    },

    loadMenus: state=>{

        return state.menus

    },

    getAll: state=>{

        return state.rows

    },

    getFind: status =>{

        return state.rows

    },

    getHeaders: state=>{

        return state.headers

    },

    getOptions: state => {

        return state.options

    }
}
