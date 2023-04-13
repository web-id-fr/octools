<template>
    <DefaultField :field="field" :errors="errors" :show-help-text="showHelpText">
        <template #field>
            <div v-for="(memberKey, serviceKey) in services">
                <p class="text-xl text-gray-200">{{ ucfirst(serviceKey) }}</p>
                <div class="mb-4">
                    <input
                        :id="serviceKey + '_identifier'"
                        type="text"
                        class="w-full mt-3 form-control form-input form-input-bordered"
                        :class="errorClasses"
                        :placeholder="memberKey"
                        :value="getResponseValue(serviceKey)"
                        @input="event => setResponseValue(serviceKey, event.target.value)"
                    />
                </div>
            </div>
        </template>
    </DefaultField>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova'
import _ from 'lodash'

export default {
  mixins: [FormField, HandlesValidationErrors],

  props: ['resourceName', 'resourceId', 'field'],

  data() {
      return {
          'response' : {},
          'services' : [],
      }
  },

  methods: {
      getResponseValue(service) {
          this.setResponseValue(service, this.value?.[service])
          return this.value?.[service] ?? ''
      },
      setResponseValue(service, value) {
          this.response[service] = value || null
      },
      ucfirst(str) {
        return _.startCase(str);
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
