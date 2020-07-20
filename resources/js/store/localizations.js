import {SET_CURRENT_LANGUAGE, SET_CURRENT_LOCALE} from "../storeConstants";

export default {

    namespaced: true,

    state: () => ({
        currentLanguage: null,
        currentLocale: {},
        locales: [],
        localeAttr: 'locale'
    }),

    mutations: {
        setCurrentLanguage(state, lang) {
            state.currentLanguage = lang;
        },
        setCurrentLocale(state) {
            state.currentLocale = state.locales.find(x => x[state.localeAttr] === state.currentLanguage)
        },
        setLocales(state, payload) {
            state.locales = payload;
        },

        setLocaleAttr(state, attrName) {
            state.localeAttr = attrName;
        },

        updateValueByAttr: (state, {attr, value}) => {
            state.currentLocale[attr] = value
        },

    },

    actions: {
        changeLocale({commit, getters}, lang) {

            return new Promise((res, rej) => {
                if (!getters.getLocaleByLang(lang)) return rej('No such translation!');

                commit(SET_CURRENT_LANGUAGE, lang);
                commit(SET_CURRENT_LOCALE);

                return res(lang);
            });

        }
    },

    getters: {
        getValueByAttribute: state => attr => {
            return state.currentLocale[attr];
        },
        getLocaleByLang: state => locale => state.locales.find(x => x[state.localeAttr] === locale)
    }
};