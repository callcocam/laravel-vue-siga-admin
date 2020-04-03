// en, de, fr, pt
let locale = "en";
let language ={}
if(window.locale){
    locale = window.locale;
}

async function languages() {
    let  { data } = await axios.get('/api/v1/admin/languages');
    return  data
}
languages().then(languages=>{
    Object.keys(languages).map(key=>{

        language[key.replace('-','')] = languages[key]['json']
    })
})

export default language
