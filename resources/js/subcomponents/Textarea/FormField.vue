<template>
    <default-field :field="field" :errors="errors" :full-width-content="true">
        <template slot="field">
      <textarea
              class="w-full form-control form-input form-input-bordered py-3 h-auto"
              :id="field.attribute"
              :dusk="field.attribute"
              :value="getValueByAttribute(field.attribute)"
              @input="updateValue"
              v-bind="extraAttributes"
      />
        </template>
    </default-field>
</template>

<script>
    import {FormField, HandlesValidationErrors} from 'laravel-nova'
    import {localeFields} from "../../mixins/localeFields";

    export default {
        mixins: [FormField, HandlesValidationErrors, localeFields],

        methods: {
            updateValue({target}) {
                const attr = this.field.attribute, value = target.value;
                this.updateValueByAttr({attr, value})
            },
            // fill(formData) {
            //     return formData;
            // }
        },

        computed: {
            defaultAttributes() {
                return {
                    rows: this.field.rows,
                    class: this.errorClasses,
                    placeholder: this.field.name,
                }
            },

            extraAttributes() {
                const attrs = this.field.extraAttributes

                return {
                    ...this.defaultAttributes,
                    ...attrs,
                }
            },
        },
    }
</script>
