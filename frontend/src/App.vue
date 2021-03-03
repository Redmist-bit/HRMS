<template>
  <v-app>
    <Appbar/>
    <v-main>
      <router-view/>
    </v-main>

  </v-app>
</template>

<script>
  import Appbar from '@/views/Appbar';
  export default {
    components: {
      Appbar,
    },
    data: () => ({
    //
    }),
  };
</script>

<style>
  @import '../node_modules/@syncfusion/ej2-base/styles/material.css';  
  @import '../node_modules/@syncfusion/ej2-buttons/styles/material.css';  
  @import '../node_modules/@syncfusion/ej2-calendars/styles/material.css';  
  @import '../node_modules/@syncfusion/ej2-dropdowns/styles/material.css';  
  @import '../node_modules/@syncfusion/ej2-inputs/styles/material.css';  
  @import '../node_modules/@syncfusion/ej2-navigations/styles/material.css';
  @import '../node_modules/@syncfusion/ej2-popups/styles/material.css';
  @import '../node_modules/@syncfusion/ej2-splitbuttons/styles/material.css';
  @import "../node_modules/@syncfusion/ej2-vue-grids/styles/material.css";
</style>