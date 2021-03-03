<template>
  <div id="app">
    <v-col>
      <ejs-grid :dataSource="data" :allowPaging="true" :pageSettings='pageSettings'>
        <e-columns>
          <e-column field='Kode' headerText='Kode' textAlign='Left' width=50></e-column>
          <e-column field='Nama' headerText='Nama' width=80></e-column>
          <e-column field='Jabatan' headerText='Jabatan' textAlign='Left' width=50></e-column>
        </e-columns>
      </ejs-grid>
    </v-col>
  </div>
</template>
<script>
import Vue from "vue";
import { GridPlugin, Page } from "@syncfusion/ej2-vue-grids";

Vue.use(GridPlugin);

export default {
  data() {
    return {
      data: [
        { Kode: '0101/0001', Nama: 'Endhy', Jabatan: 'IT' },
          
      ],
      pageSettings: { pageSize: 5 }
    };
  },
  provide: {
    grid: [Page]
  }
}
</script>


{% endraw %}