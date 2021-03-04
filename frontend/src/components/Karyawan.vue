<template>
  <div id="app">
    <v-col>
      <v-card outlined class="rounded-lg">
        <v-col>
          <v-toolbar
            dense
            flat
            color="grey lighten-2"
          >
            <v-toolbar-title dark color="white">
              Data Karyawan
            </v-toolbar-title>
          </v-toolbar>
          <ejs-grid
            :dataSource="data"
            :allowPaging="true"
            :allowSorting='true'
            :allowGrouping='true'
            :pageSettings='pageSettings'
          >
            <e-columns>
              <e-column field='Kode' headerText='Kode' textAlign='Left' width=50></e-column>
              <e-column field='Nama' headerText='Nama' width=80></e-column>
              <e-column field='Jabatan' headerText='Jabatan' textAlign='Left' width=50></e-column>
            </e-columns>
          </ejs-grid>
        </v-col>
      </v-card>
    </v-col>
  </div>
</template>
<script>
import Vue from "vue";
import { GridPlugin, Page, Sort, Group } from "@syncfusion/ej2-vue-grids";

Vue.use(GridPlugin);

export default {
  data() {
    return {
      data: [
        { Kode: '0101/0001', Nama: 'Endhy', Jabatan: 'IT' },
        { Kode: '0101/0002', Nama: 'Bayu', Jabatan: 'IT' },
        { Kode: '0101/0003', Nama: 'Devian', Jabatan: 'IT' },
        { Kode: '0101/0004', Nama: 'Resky', Jabatan: 'IT' },
      ],
      pageSettings: { pageSize: 5 }
    };
  },
  provide: {
    grid: [Page, Sort, Group]
  }
}
</script>


{% endraw %}