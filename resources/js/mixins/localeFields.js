import {MODULE_NAMESPACE} from "../constants";
import {UPDATE_VALUE_BY_ATTR} from "../storeConstants";

import {createNamespacedHelpers} from "vuex";

const {mapMutations, mapGetters, mapState} = createNamespacedHelpers(MODULE_NAMESPACE);

const localeFields = {
    computed: {

        ...mapState({
           currentLanguage: state => state.currentLanguage
        }),
        ...mapGetters({
            getValueByAttribute: 'getValueByAttribute',
        }),
    },

    methods: {

        ...mapMutations({
            updateValueByAttr: UPDATE_VALUE_BY_ATTR
        }),

        fill(formData) {
            formData.append(`locales-payload[${this.field.attribute}]`, this.getValueByAttribute(this.field.attribute) || '');


            formData.append(this.field.attribute, this.getValueByAttribute(this.field.attribute) || '');
        }
    },
}


export {localeFields}