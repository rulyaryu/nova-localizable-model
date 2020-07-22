<template>
    <default-field :field="field" :errors="errors">
        <template slot="field">
            <input
                    class="w-full form-control form-input form-input-bordered"
                    :id="field.attribute"
                    :dusk="field.attribute"
                    :value="getValueByAttribute(field.attribute)"
                    @input="updateValue"
                    v-bind="extraAttributes"
                    :disabled="isReadonly"
                    :list="`${field.attribute}-list`"
            />

            <datalist
                    v-if="field.suggestions && field.suggestions.length > 0"
                    :id="`${field.attribute}-list`"
            >
                <option v-for="suggestion in field.suggestions" :value="suggestion"/>
            </datalist>
        </template>
    </default-field>
</template>

<script>
    import {FormField, HandlesValidationErrors} from 'laravel-nova'
    import {localeFields} from "../../mixins/localeFields";

    export default {
        mixins: [HandlesValidationErrors, FormField, localeFields],


        methods: {
            updateValue({target}) {

                const {attribute: attr, eventName} = this.field, value = target.value;

                if(this.field.eventName) {
                    Nova.$emit(eventName, {value})
                }

                this.updateValueByAttr({attr, value})
            },
            // fill(formData) {
            //     return formData;
            // }
        },

        computed: {
            defaultAttributes() {
                return {
                    type: this.field.type || 'text',
                    min: this.field.min,
                    max: this.field.max,
                    step: this.field.step,
                    pattern: this.field.pattern,
                    placeholder: this.field.placeholder || this.field.name,
                    class: this.errorClasses,
                }
            },

            extraAttributes() {
                const attrs = this.field.extraAttributes

                return {
                    // Leave the default attributes even though we can now specify
                    // whatever attributes we like because the old number field still
                    // uses the old field attributes
                    ...this.defaultAttributes,
                    ...attrs,
                }
            },
        },
    }
</script>
