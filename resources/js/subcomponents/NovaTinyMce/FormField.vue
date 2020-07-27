<template>
    <default-field :field="field" :full-width-content="true">
        <template slot="field">
            <editor :api-key="tinymce_api_key"
                    :id="field.attribute"
                    v-model="localeValue"
                    :class="errorClasses"
                    :placeholder="field.name"
                    :init="options"
            ></editor>

            <p v-if="hasError" class="my-2 text-danger">
                {{ firstError }}
            </p>
        </template>
    </default-field>
</template>

<script>
    import {FormField, HandlesValidationErrors} from 'laravel-nova'
    import Editor from '@tinymce/tinymce-vue'
    import {localeFields} from "../../mixins/localeFields";

    export default {
        components: {Editor},

        mixins: [FormField, HandlesValidationErrors, localeFields],

        props: ['resourceName', 'resourceId', 'field'],

        computed: {
            tinymce_api_key() {
                return Nova.config.tinymce_api_key
            },

            options() {
                let options = this.field.options

                if (options.use_lfm) {
                    options['file_browser_callback'] = this.filemanager
                }

                return options
            },

            localeValue: {
                get() {
                    return this.getValueByAttribute(this.field.attribute) || ''
                },
                set(value) {
                    const attr = this.field.attribute;
                    return this.updateValueByAttr({attr, value})
                }
            }
        },

        methods: {

            filemanager(field_name, url, type, win) {
                let x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                let y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight;

                let cmsURL = this.options.path_absolute + this.options.lfm_url + '?field_name=' + field_name;
                if (type == 'image') {
                    cmsURL = cmsURL + '&type=Images';
                } else {
                    cmsURL = cmsURL + '&type=Files';
                }

                tinyMCE.activeEditor.windowManager.open({
                    file: cmsURL,
                    title: 'Filemanager',
                    width: x * 0.8,
                    height: y * 0.8,
                    resizable: 'yes',
                    close_previous: 'no'
                });
            },

        }
    }
</script>
