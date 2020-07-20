import localizations from "./store/localizations";

Nova.booting((Vue, router, store) => {


    Vue.component('index-nova-localizable-model', require('./components/IndexField'))
    Vue.component('detail-nova-localizable-model', require('./components/DetailField'))
    Vue.component('form-nova-localizable-model', require('./components/FormField'))


    // Boolean
    Vue.component('index-boolean-locale', require('./subcomponents/Boolean/IndexField.vue'))
    // Vue.component('detail-boolean-locale', require('./subcomponents/Boolean/DetailField.vue'))
    Vue.component('form-boolean-locale', require('./subcomponents/Boolean/FormField.vue'))

    //Text
    Vue.component('index-text-locale', require('./subcomponents/Text/IndexField.vue'))
    // Vue.component('detail-text-locale', require('./subcomponents/Text/DetailField.vue'))
    Vue.component('form-text-locale', require('./subcomponents/Text/FormField.vue'))

    // Textarea
    Vue.component('index-textarea-locale', require('./subcomponents/Text/IndexField.vue'))
    Vue.component('detail-textarea-locale', require('./subcomponents/Textarea/DetailField.vue'))
    Vue.component('form-textarea-locale', require('./subcomponents/Textarea/FormField.vue'))

    // NovaTinyMce

    Vue.component('form-nova-tiny-mce-locale', require('./subcomponents/NovaTinyMce/FormField'))
    Vue.component('detail-nova-tiny-mce-locale', require('./subcomponents/NovaTinyMce/IndexField'))
    Vue.component('index-nova-tiny-mce-locale', require('./subcomponents/NovaTinyMce/DetailField'))

})
