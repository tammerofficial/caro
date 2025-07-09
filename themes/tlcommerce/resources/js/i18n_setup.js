
import { createI18n } from 'vue-i18n'
import axios from "axios";

const i18n = createI18n({
    locale: localStorage.getItem("locale") || "en",
    fallbackLocale: "en",
    legacy: false,
    messages: {}

})

const loadedLanguages = [];

function setI18nLanguage(lang) {
    i18n.locale = lang;
    axios.defaults.headers.common["Accept-Language"] = lang;
    document.querySelector("html").setAttribute("lang", lang);
    return lang;
}

export async function loadLanguageAsync(lang) {
    if (loadedLanguages.includes(lang)) {
        if (i18n.locale !== lang) {
            return Promise.resolve(setI18nLanguage(lang));
        }
    }
    return axios.get(`/api/v1/locale/${lang}`).then(response => {
        let messages = response.data.data;
        let language = response.data.language;
        var html = document.querySelector("html");
        html.className = language.is_rtl == 1 ? "rtl" : "";
        loadedLanguages.push(lang);
        i18n.global.setLocaleMessage(lang, messages);
        return Promise.resolve(setI18nLanguage(lang));
    });
}
export default i18n;