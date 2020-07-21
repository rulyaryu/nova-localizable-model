<template>
    <default-field :field="field" :errors="errors">
        <template slot="field">
            <select class="form-control form-select"
                    @change="handleChangeLanguage"
                    name="" id="">
                <option :key="l.lang" v-for="l in localeVariants" :value="l.lang">
                    {{l.label}}
                </option>
            </select>
        </template>
    </default-field>
</template>

<script>
    import {FormField, HandlesValidationErrors} from 'laravel-nova'
    import {createNamespacedHelpers} from "vuex";

    const {mapActions, mapMutations, mapState} = createNamespacedHelpers(MODULE_NAMESPACE);

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

        data() {
            const localeVariants = this.field.localeVariants;
            return {
                localeVariants
            }
        },

        mounted() {

            const {localeAttribute, isCreateMode, creationDefaultLocale} = this.field;

            this.setLocaleAttr(localeAttribute);


            if (isCreateMode) {
                const defaultLocales = [
                    {[localeAttribute]: creationDefaultLocale}
                ];

                this.localeVariants = this.localeVariants.filter((v) => v.lang === creationDefaultLocale);

                this.setLocales(defaultLocales);


            } else {
                this.setLocales(this.value);
            }


            // this.setCurrentLanguage(this.field.localeVariants[0].lang);

            let lang = this.field.localeVariants[0].lang;

            this.updateLocale(lang)

        },

        computed: {
            ...mapState({
                locales: state => state.locales,
                currentLocale: state => state.currentLocale,
                currentLanguage: state => state.currentLanguage,
            })
        },

        methods: {

            ...mapActions({
                changeLocale: CHANGE_LOCALE
            }),

            ...mapMutations({
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

                const {attribute, defaultLocalesRelationName, localeAttribute} = this.field;

                formData.append([attribute, 'selected_locale'].join('_'), this.currentLanguage);
                formData.append('default_locales_relation_name', defaultLocalesRelationName);
                formData.append('default_locale_attr', localeAttribute);

                // formData.append(attribute, JSON.stringify(this.currentLocale));
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
