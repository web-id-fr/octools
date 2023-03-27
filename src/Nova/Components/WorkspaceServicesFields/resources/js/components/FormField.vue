<template>
  <DefaultField :field="field" :errors="errors" :show-help-text="showHelpText" :full-width-content="fullWidthContent">
    <template #field>
        <div v-for="(configs, service) in services">
            <p class="text-xl text-gray-200">{{ service }}</p>
            <div v-for="config in configs" class="mb-4">
                <input
                    :id="config"
                    type="text"
                    class="w-full mt-3 form-control form-input form-input-bordered"
                    :class="errorClasses"
                    :placeholder="config"
                    :value="getResponseValue(service, config)"
                    @input="event => setResponseValue(service, config, event.target.value)"
                />
            </div>
        </div>
    </template>
  </DefaultField>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova'
import DetailField from "./DetailField.vue";

export default {
  components: {DetailField},
  mixins: [FormField, HandlesValidationErrors],

  props: ['resourceName', 'resourceId', 'field'],

  data() {
    return {
        'response' : {},
        'services' : [],
    }
  },

  methods: {
      getResponseValue(service, config) {
          this.setResponseValue(service, config, this.value?.[service]?.[config])
          return this.value?.[service]?.[config] ?? ''
      },
      setResponseValue(service, config, value) {
          if (!this.response?.[service]) {
              this.response[service] = {}
          }
          this.response[service][config] = value || null
      },
    /*
     * Set the initial, internal value for the field.
     */
    setInitialValue() {
      this.value = this.field.value || {};
      this.services = this.field.services || []
    },

    /**
     * Fill the given FormData object with the field's internal value.
     */
    fill(formData) {
        formData.append(this.field.attribute, JSON.stringify(this.response))
    },
  },
}
</script>
