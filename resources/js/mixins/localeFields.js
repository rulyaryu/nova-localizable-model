import {mapGetters, mapMutations, mapState} from "vuex";
import {MODULE_NAMESPACE} from "../constants";
import {UPDATE_VALUE_BY_ATTR} from "../storeConstants";

const localeFields = {
    computed: {

        ...mapState(MODULE_NAMESPACE, {
           currentLanguage: state => state.currentLanguage
        }),
        ...mapGetters(MODULE_NAMESPACE, {
            getValueByAttribute: 'getValueByAttribute',
        }),
    },

    methods: {

        ...mapMutations(MODULE_NAMESPACE, {
            updateValueByAttr: UPDATE_VALUE_BY_ATTR
        }),

        fill(formData) {
            formData.append([this.currentLanguage, this.field.attribute].join('_'), this.getValueByAttribute(this.field.attribute) || '');
        }
    },
}


export {localeFields}