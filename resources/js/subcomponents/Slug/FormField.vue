<template>
	<default-field :field="field" :errors="errors">
		<template slot="field">
			<div class="flex items-center">
				<input
					class="w-full form-control form-input form-input-bordered"
					:id="field.attribute"
					:dusk="field.attribute"
					:value="getValueByAttribute(field.attribute)"
					@input="updateValue"
					v-bind="extraAttributes"
					:disabled="!canBeUpdated"
					:list="`${field.attribute}-list`"
				/>

				<button
					class="btn btn-link rounded px-1 py-1 inline-flex text-sm text-primary ml-1 mt-2"
					v-if="!canBeUpdated"
					type="button"
					@click="setCanBeUpdated"
				>
					{{ __('Customize') }}
				</button>

			</div>
		</template>
	</default-field>
</template>

<script>
import {FormField, HandlesValidationErrors} from 'laravel-nova'
import {localeFields} from "../../mixins/localeFields";

export default {
	mixins: [HandlesValidationErrors, FormField, localeFields],


	data() {
		return {
			canBeUpdated: this.field.canBeUpdated
		}
	},

	mounted() {
		if (!this.field.eventName) {
			this.$toasted.show('Event name wasn\'t provided', {type: 'error'})
			return;
		}
		Nova.$on(this.field.eventName, ({value}) => {
			this.getSlugFromTitle(value)
		});
	},

	beforeDestroy() {
		Nova.$off(this.field.eventName);
	},

	methods: {

		setCanBeUpdated() {
			this.canBeUpdated = true
		},

		getSlugFromTitle(title) {

			if(!this.canBeUpdated) {
				return;
			}

			const {attribute: attr} = this.field;

			axios.get(`/nova-vendor/nova-localizable-model/get-slug-from-title/${title}`)
				.then(({data: value}) => this.updateValueByAttr({attr, value}))
				.catch(console.error)
		},

		updateValue({target}) {
			const {attribute: attr, eventName} = this.field, value = target.value;
			this.updateValueByAttr({attr, value})
		},
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
