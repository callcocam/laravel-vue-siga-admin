// 'loggedIn' is used in other parts of application. So, Don't forget to change there also
const localStorageKey = 'loggedIn';
const localStorageInfo = 'userInfo';
const tokenExpiryKey = 'tokenExpiry';
const localStorageToken = 'accessToken';
import store from "@store";
class AuthService {
    logOut() {
        store.commit("UPDATE_USER_INFO",null)
        localStorage.removeItem(localStorageKey);
        localStorage.removeItem(tokenExpiryKey);
        localStorage.removeItem(localStorageInfo);
        localStorage.removeItem(localStorageToken);

    }
    isAuthenticated() {
        let result = (
            new Date(Date.now()) < new Date(localStorage.getItem(tokenExpiryKey)) &&
            localStorage.getItem(localStorageKey) === 'true'
        );
        return result;
    }

    setAuthenticated() {
        if (this.isAuthenticated()){
            store.commit("UPDATE_USER_INFO",JSON.parse(localStorage.getItem(localStorageInfo)))
        }
    }
}

export default new AuthService();
