<template>
  <div>
    <v-switch
      v-model="$vuetify.theme.dark"
      hide-details
      color="red darken-4"
      label="Mode Malam"
    ></v-switch>
  </div>
</template>
<script>
import Vue from 'vue'
import Vuetify from 'vuetify/lib'

Vue.use(Vuetify)
export default new Vuetify ({
  theme: { dark: true },
  props: {
      attrs: {
        type: Object,
        default: () => ({}),
      },
    },
  data: vm => {
    return {
      initialDark: vm.$vuetify
      ? vm.$vuetify.theme.dark
      : false,
    }
  },
  methods: {
    
  },
});
</script>