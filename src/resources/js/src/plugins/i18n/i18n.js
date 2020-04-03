import Vue from 'vue'
import VueI18n from 'vue-i18n'
import i18nData from './i18nData'
let locale = "en";
let language ={}
if(window.locale){
    locale = window.locale;
}
Vue.use(VueI18n)
console.log(i18nData)
export default new VueI18n({
    locale: locale.replace('-',''), // set default locale
    messages: i18nData,
})
