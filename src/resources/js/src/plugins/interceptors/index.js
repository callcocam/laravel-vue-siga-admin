import store from "@store";
// Token Refresh
let isAlreadyFetchingAccessToken = false

let subscribers = []

function onAccessTokenFetched(access_token) {
    subscribers = subscribers.filter(callback => callback(access_token))
}

function addSubscriber(callback) {
    subscribers.push(callback)
}
export default {
    response(axios) {
        axios.interceptors.response.use(function (response) {
            return response
        }, function (error) {
            // const { config, response: { status } } = error
            const { config, response } = error
            const originalRequest = config

            // if (status === 401) {
            if (response && response.status === 401) {
                if (!isAlreadyFetchingAccessToken) {
                    isAlreadyFetchingAccessToken = true
                    store.dispatch("fetchAccessToken")
                        .then((access_token) => {
                            isAlreadyFetchingAccessToken = false
                            onAccessTokenFetched(access_token)
                        })
                }

                const retryOriginalRequest = new Promise((resolve) => {
                    addSubscriber(access_token => {
                        originalRequest.headers.Authorization = 'Bearer ' + access_token
                        resolve(axios(originalRequest))
                    })
                })
                return retryOriginalRequest
            }
            return Promise.reject(error)
        })
    },
    request(axios) {
        axios.interceptors.request.use(function(config) {

            const token = localStorage.getItem('accessToken');
            if(token) {
                config.headers.Authorization = `Bearer ${token}`;
            }
            return config;
        }, function(err) {
            return Promise.reject(err);
        });
    }
}
