<template>
    <default-field :field="field" :errors="errors">
        <template slot="field">
            <checkbox
                    class="mt-2"
                    :id="field.attribute"
                    :name="field.name"
                    @input="updateValue"
                    :checked="Boolean(getValueByAttribute(field.attribute))"
                    :disabled="isReadonly"
            />
        </template>
    </default-field>
</template>

<script>
    import {Errors, FormField, HandlesValidationErrors} from 'laravel-nova'
    import {localeFields} from "../../mixins/localeFields";

    export default {
        mixins: [HandlesValidationErrors, FormField, localeFields],

        data: () => ({
            value: false,
        }),

        // mounted() {
        //     this.field.fill = formData => {
        //         formData.append(this.field.attribute, this.trueValue)
        //     }
        // },

        methods: {
            // toggle() {
            //     this.value = !this.value
            // },


            fill(formData) {

                const {attribute} = this.field;

                formData.append(`locales-payload[${attribute}]`, +Boolean(this.getValueByAttribute(attribute)));
                formData.append(attribute, +Boolean(this.getValueByAttribute(attribute)));
            },

            updateValue() {
                const attr = this.field.attribute, value = !Boolean(this.getValueByAttribute(attr));

                this.updateValueByAttr({attr, value})
            }
        },

        computed: {
            // checked() {
            //     return Boolean()
            // },
            //
            // trueValue() {
            //     return +this.checked
            // },
        },
    }
</script>
