// en, de, fr, pt
let locale = "en";
let language ={}
if(window.locale){
    locale = window.locale;
}
if(window._translations){
    Object.keys(window._translations).map(key=>{
        language[key.replace('-','')] = window._translations[key]['json']
    })
}
export default language
