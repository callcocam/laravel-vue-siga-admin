/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

export  default {
    userInfo({ commit }, data) {
        if(data.userData) {

            localStorage.setItem("accessToken", data.accessToken)

            localStorage.setItem('loggedIn', 'true');

            localStorage.setItem('tokenExpiry', new Date(data.exp * 1000).toString());

            // Update user details
            commit('SET_USER_INFO', data.userData, {root: true})
            // Set bearer token in axios
            commit("SET_BEARER", data.accessToken)

        }
    },
    all({commit}, data){


    },

    find({ commit }, data){

    },

    delete({ commit }, data){


    },

   async fetchAccessToken({ commit }){

     let { data } = await axios.post('/api/v1/admin/refresh');

     return  data;
    }
}
