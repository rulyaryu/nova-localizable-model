<template>
    <default-field :field="field" :errors="errors">
        <template slot="field">
            <select class="form-control form-select"
                    @change="handleChangeLanguage"
                    name="" id="">
                <option :key="l.lang" v-for="l in field.localeVariants" :value="l.lang">
                    {{l.label}}
                </option>
            </select>
        </template>
    </default-field>
</template>

<script>
    import {FormField, HandlesValidationErrors} from 'laravel-nova'
    import {mapActions, mapMutations, mapState} from "vuex";
    import localizations from "../store/localizations";
    import {MODULE_NAMESPACE} from "../constants";
    import {
        CHANGE_LOCALE,
        SET_CURRENT_LANGUAGE,
        SET_CURRENT_LOCALE,
        SET_LOCALE_ATTR,
        SET_LOCALES
    } from "../storeConstants";


    export default {
        mixins: [FormField, HandlesValidationErrors],

        props: ['resourceName', 'resourceId', 'field'],

        beforeCreate() {
            this.$store.registerModule(MODULE_NAMESPACE, localizations);
        },
        beforeDestroy() {
            this.$store.unregisterModule(MODULE_NAMESPACE)
        },

        mounted() {


            console.log(this.field.localeAttribute);
            console.log(this.field.localeVariants);

            // this.handleChangeLanguage();

            this.setLocaleAttr(this.field.localeAttribute);

            this.setLocales(this.value);

            // this.setCurrentLanguage(this.field.localeVariants[0].lang);

            let lang = this.field.localeVariants[0].lang;

            this.updateLocale(lang)

        },

        computed: {
            ...mapState(MODULE_NAMESPACE, {
                locales: state => state.locales,
                currentLocale: state => state.currentLocale,
                currentLanguage: state => state.currentLanguage,
            })
        },

        methods: {

            ...mapActions(MODULE_NAMESPACE, {
                changeLocale: CHANGE_LOCALE
            }),

            ...mapMutations(MODULE_NAMESPACE, {
                setCurrentLanguage: SET_CURRENT_LANGUAGE,
                setCurrentLocale: SET_CURRENT_LOCALE,
                setLocales: SET_LOCALES,
                setLocaleAttr: SET_LOCALE_ATTR
            }),

            handleChangeLanguage({target}) {

                // this.setCurrentLanguage(target.value);

                this.updateLocale(target.value)
                    .then(_ => Nova.$emit('model-locale-changed', this.currentLanguage));

            },

            updateLocale(lang) {
                return this.changeLocale(lang)
                    .then(this.showSuccess(`Выбран перевод на ${lang}`))
                    .catch(this.showError(`Перевод на ${lang} отсутсвует!`))
            },

            /*
             * Set the initial, internal value for the field.
             */
            setInitialValue() {
                this.value = this.field.value || ''
            },

            /**
             * Fill the given FormData object with the field's internal value.
             */
            fill(formData) {

                formData.append([this.field.attribute, 'selected_locale'].join('_'), this.currentLanguage);
                formData.append('default_locales_relation_name', this.field.defaultLocalesRelationName);
                formData.append('default_locale_attr', this.field.localeAttribute);

                // return formData.append(this.field.attribute, JSON.stringify(this.currentLocale));
            },

            showSuccess(message) {
                return () => this.$toasted.show(message, {type: 'success'})
            },

            showError(message) {
                return () => this.$toasted.show(message, {type: 'error'})
            }

        },
    }
</script>
