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
              Tabel Data Karyawan
            </v-toolbar-title>
            <v-spacer></v-spacer>

            <!-- Dialog Tambah Karyawan -->
            <v-dialog
              v-model="DialogTambahKaryawan"
              max-width="1200px"
              scrollable
              persistent
              
              transition="dialog-bottom-transition"
            >
              <template v-slot:activator="{ on, attrs }">
                <v-btn
                  class="text-capitalize mx-n2"
                  color="grey lighten-2"
                  v-bind="attrs"
                  v-on="on"
                >
                  Tambah
                </v-btn>
              </template>
              <v-card>
                <v-toolbar
                  flat
                >
                  <v-card-title>
                    <span class="headline">{{ formTitleKaryawan }}</span>
                  </v-card-title>
                  <v-spacer></v-spacer>
                  <v-btn
                    fab
                    text
                    small
                    @click="KeluarDialogKaryawan"
                  >
                    <v-icon>mdi-window-close</v-icon>
                  </v-btn>
                </v-toolbar>
                <v-divider></v-divider>
                
                <v-card-text>
                  <v-container class="mt-3">
                    <v-row>
                      <v-col cols="12" sm="6" md="3">
                        <v-text-field
                          dense
                          color="grey darken-2"
                          label="Kode Karyawan"
                          v-model="editedItem.KODE_KARYAWAN"
                        ></v-text-field>
                      </v-col>

                      <v-col cols="12" sm="6" md="3">
                        <v-text-field
                          dense
                          clearable
                          label="Nama"
                          color="grey darken-2"
                          v-model="editedItem.NAMA"
                        ></v-text-field>
                      </v-col>

                      <v-col cols="12" sm="6" md="3">
                        <v-text-field
                          dense
                          clearable
                          label="NRK"
                          color="grey darken-2"
                          v-model="editedItem.NRK"
                        ></v-text-field>
                      </v-col>

                      <v-col cols="12" sm="6" md="3">
                        <v-text-field
                          dense
                          label="Kode Jabatan"
                          color="grey darken-2"
                          v-model="editedItem.KODE_JABATAN"
                        ></v-text-field>
                      </v-col>

                      <v-col cols="12" sm="6" md="3">
                        <v-text-field
                          dense
                          clearable
                          label="POH"
                          color="grey darken-2"
                          v-model="editedItem.POH"
                        ></v-text-field>
                      </v-col>

                      <v-col cols="12" sm="6" md="3">
                        <v-menu
                          v-model="MenuTglMasuk"
                          :close-on-content-click="false"
                          :nudge-right="40"
                          transition="scale-transition"
                          offset-y
                          min-width="auto"
                        >
                          <template v-slot:activator="{ on, attrs }">
                            <v-text-field
                              v-model="editedItem.TGL_MASUK"
                              label="Tgl Masuk"
                              prepend-icon="mdi-calendar"
                              color="grey darken-2"
                              readonly
                              dense
                              v-bind="attrs"
                              v-on="on"
                            ></v-text-field>
                          </template>
                          <v-date-picker
                            v-model="editedItem.TGL_MASUK"
                            @input="MenuTglMasuk = false"
                            color="red darken-4"
                            locale="id"
                          ></v-date-picker>
                        </v-menu>
                      </v-col>

                      <v-col cols="12" sm="6" md="3">
                        <v-text-field
                          dense
                          clearable
                          label="Tempat Lahir"
                          color="grey darken-2"
                          v-model="editedItem.TEMPAT_LAHIR"
                        ></v-text-field>
                      </v-col>

                      <v-col cols="12" sm="6" md="3">
                        <v-menu
                          v-model="MenuTglLahir"
                          :close-on-content-click="false"
                          :nudge-right="40"
                          transition="scale-transition"
                          offset-y
                          min-width="auto"
                        >
                          <template v-slot:activator="{ on, attrs }">
                            <v-text-field
                              v-model="editedItem.TGL_LAHIR"
                              label="Tgl Lahir"
                              prepend-icon="mdi-calendar"
                              color="grey darken-2"
                              readonly
                              dense
                              v-bind="attrs"
                              v-on="on"
                            ></v-text-field>
                          </template>
                          <v-date-picker
                            v-model="editedItem.TGL_LAHIR"
                            @input="MenuTglMasuk = false"
                            color="red darken-4"
                            :max="new Date().toISOString().substr(0, 10)"
                            min="1950-01-01"
                            locale="id"
                            ref="picker"
                          ></v-date-picker>
                        </v-menu>
                      </v-col>

                      <v-col cols="12" sm="6" md="3">
                        <v-text-field
                          dense
                          clearable
                          label="Alamat KTP"
                          color="grey darken-2"
                          v-model="editedItem.ALAMAT_KTP"
                        ></v-text-field>
                      </v-col>

                      <v-col cols="12" sm="6" md="3">
                        <v-text-field
                          dense
                          clearable
                          label="Alamat Sekarang"
                          color="grey darken-2"
                          v-model="editedItem.ALAMAT_SEKARANG"
                        ></v-text-field>
                      </v-col>

                      <v-col cols="12" sm="6" md="3">
                        <v-text-field
                          dense
                          clearable
                          label="No. Tlp"
                          color="grey darken-2"
                          v-model="editedItem.NO_TLP"
                        ></v-text-field>
                      </v-col>

                      <v-col cols="12" sm="6" md="3">
                        <v-combobox
                          dense
                          clearable
                          :items="['Laki-Laki','Perempuan']"
                          label="Jenis Kelamin"
                          color="grey darken-2"
                          v-model="editedItem.JENIS_KELAMIN"
                        ></v-combobox>
                      </v-col>

                      <v-col cols="12" sm="6" md="3">
                        <v-text-field
                          dense
                          clearable
                          label="Pendidikan Terakhir"
                          color="grey darken-2"
                          v-model="editedItem.PENDIDIKAN_TERAKHIR"
                        ></v-text-field>
                      </v-col>

                      <v-col cols="12" sm="6" md="3">
                        <v-text-field
                          dense
                          clearable
                          label="Jurusan"
                          color="grey darken-2"
                          v-model="editedItem.JURUSAN"
                        ></v-text-field>
                      </v-col>

                      <v-col cols="12" sm="6" md="3">
                        <v-combobox
                          dense
                          clearable
                          :items="['Islam','Protestan','Katolik','Hindu','Buddha','Khonghucu']"
                          label="Agama"
                          color="grey darken-2"
                          v-model="editedItem.AGAMA"
                        ></v-combobox>
                      </v-col>

                      <v-col cols="12" sm="6" md="3">
                        <v-text-field
                          dense
                          clearable
                          label="Suku"
                          color="grey darken-2"
                          v-model="editedItem.SUKU"
                        ></v-text-field>
                      </v-col>

                      <v-col cols="12" sm="6" md="3">
                        <v-text-field
                          dense
                          clearable
                          label="No. Rekening Tabungan"
                          color="grey darken-2"
                          v-model="editedItem.NO_REK_TABUNGAN"
                        ></v-text-field>
                      </v-col>

                      <v-col cols="12" sm="6" md="3">
                        <v-text-field
                          dense
                          clearable
                          label="No. Kartu BPJS TK"
                          color="grey darken-2"
                          v-model="editedItem.NO_KARTU_BPJS_TK"
                        ></v-text-field>
                      </v-col>

                      <v-col cols="12" sm="6" md="3">
                        <v-text-field
                          dense
                          clearable
                          label="No. Kartu BPJS KES"
                          color="grey darken-2"
                          v-model="editedItem.NO_KARTU_BPJS_KES"
                        ></v-text-field>
                      </v-col>

                      <v-col cols="12" sm="6" md="3">
                        <v-text-field
                          dense
                          clearable
                          label="No. KTP"
                          color="grey darken-2"
                          v-model="editedItem.NO_KTP"
                        ></v-text-field>
                      </v-col>

                      <v-col cols="12" sm="6" md="3">
                        <v-text-field
                          dense
                          clearable
                          label="No. NPWP"
                          color="grey darken-2"
                          v-model="editedItem.NO_NPWP"
                        ></v-text-field>
                      </v-col>

                      <v-col cols="12" sm="6" md="3">
                        <v-text-field
                          dense
                          clearable
                          label="Golongan Darah"
                          color="grey darken-2"
                          v-model="editedItem.GOL_DR"
                        ></v-text-field>
                      </v-col>

                      <v-col cols="12" sm="6" md="3">
                        <v-text-field
                          dense
                          clearable
                          label="Status"
                          color="grey darken-2"
                          v-model="editedItem.STATUS"
                        ></v-text-field>
                      </v-col>

                      <v-col cols="12" sm="6" md="3">
                        <v-text-field
                          dense
                          clearable
                          label="Status Kerja"
                          color="grey darken-2"
                          v-model="editedItem.STATUS_KERJA"
                        ></v-text-field>
                      </v-col>

                      <v-col cols="12" sm="6" md="3">
                        <v-text-field
                          dense
                          clearable
                          label="Ukuran Baju"
                          color="grey darken-2"
                          v-model="editedItem.UKURAN_BAJU"
                        ></v-text-field>
                      </v-col>

                      <v-col cols="12" sm="6" md="3">
                        <v-text-field
                          dense
                          clearable
                          label="Ukuran Sepatu"
                          color="grey darken-2"
                          v-model="editedItem.UKURAN_SEPATU"
                        ></v-text-field>
                      </v-col>

                      <v-col cols="12" sm="6" md="3">
                        <v-text-field
                          dense
                          clearable
                          label="PHK"
                          color="grey darken-2"
                          v-model="editedItem.PHK"
                        ></v-text-field>
                      </v-col>

                      <v-col cols="12" sm="6" md="3">
                        <v-menu
                          v-model="MenuTglPHK"
                          :close-on-content-click="false"
                          :nudge-right="40"
                          transition="scale-transition"
                          offset-y
                          min-width="auto"
                        >
                          <template v-slot:activator="{ on, attrs }">
                            <v-text-field
                              v-model="editedItem.TGL_PHK"
                              label="Tgl PHK"
                              prepend-icon="mdi-calendar"
                              color="grey darken-2"
                              readonly
                              dense
                              v-bind="attrs"
                              v-on="on"
                            ></v-text-field>
                          </template>
                          <v-date-picker
                            v-model="editedItem.TGL_PHK"
                            @input="MenuTglPHK = false"
                            color="red darken-4"
                            locale="id"
                          ></v-date-picker>
                        </v-menu>
                      </v-col>

                      <v-col cols="12" sm="6" md="3">
                        <v-text-field
                          dense
                          clearable
                          label="Keterangan"
                          color="grey darken-2"
                          v-model="editedItem.KETERANGAN"
                        ></v-text-field>
                      </v-col>

                      <v-col cols="12" sm="6" md="3">
                        <v-text-field
                          dense
                          clearable
                          label="Photo"
                          color="grey darken-2"
                          v-model="editedItem.PHOTO"
                        ></v-text-field>
                      </v-col>

                      <v-col cols="12" sm="6" md="3">
                        <v-text-field
                          dense
                          clearable
                          label="Nama Istri Suami"
                          color="grey darken-2"
                          v-model="editedItem.NAMA_ISTRI_SUAMI"
                        ></v-text-field>
                      </v-col>
                      <!-- --------------------------------- -->
                    </v-row>
                  </v-container>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                <v-spacer></v-spacer>
                  <v-btn
                    dark
                    color="red darken-4 mx-4"
                    class="text-capitalize"
                    @click="Reset"
                  >
                    <v-icon class="mr-1">mdi-cancel</v-icon>
                    Batal
                  </v-btn>
                  <v-btn
                    dark
                    color="red darken-4 mx-n2"
                    class="text-capitalize"
                    @click="Simpan"
                  >
                    <v-icon class="mr-1">mdi-content-save</v-icon>
                    Simpan
                  </v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>
          </v-toolbar>

          <ejs-grid
            height="300"
            gridLines='Both'
            :dataSource="DataKaryawan"
            :allowPaging="true"
            :allowSorting='true'
            :allowResizing='true'
            :allowGrouping='true'
            :toolbar='toolbarOptions'
            :pageSettings='pageSettings'
          >
            <e-columns>
              <e-column field='KODE_KARYAWAN' headerText='Kode' textAlign='Left' width=150></e-column>
              <e-column field='NAMA' headerText='Nama' width=300></e-column>
              <e-column field='NRK' headerText='NRK' textAlign='Left' width=150></e-column>
              <e-column field='KODE_JABATAN' headerText='Kode Jabatan' textAlign='Left' width=150></e-column>
              <e-column field='POH' headerText='POH' textAlign='Left' width=150></e-column>
              <e-column field='TGL_MASUK' headerText='Tgl Masuk' textAlign='Left' width=150></e-column>
              <e-column field='TEMPAT_LAHIR' headerText='Tempat Lahir' textAlign='Left' width=150></e-column>
              <e-column field='TGL_LAHIR' headerText='Tgl Lahir' textAlign='Left' width=150></e-column>
              <e-column field='ALAMAT_KTP' headerText='Alamat KTP' textAlign='Left' width=200></e-column>
              <e-column field='ALAMAT_SEKARANG' headerText='Alamat Sekarang' textAlign='Left' width=200></e-column>
              <e-column field='NO_TLP' headerText='No. Tlp' textAlign='Left' width=150></e-column>
              <e-column field='JENIS_KELAMIN' headerText='Jenis Kelamin' textAlign='Left' width=150></e-column>
              <e-column field='PENDIDIKAN_TERAKHIR' headerText='Pendidikan Terakhir' textAlign='Left' width=150></e-column>
              <e-column field='JURUSAN' headerText='Jurusan' textAlign='Left' width=150></e-column>
              <e-column field='AGAMA' headerText='Agama' textAlign='Left' width=150></e-column>
              <e-column field='SUKU' headerText='Suku' textAlign='Left' width=150></e-column>
              <e-column field='NO_REK_TABUNGAN' headerText='No. RekTabungan' textAlign='Left' width=150></e-column>
              <e-column field='NO_KARTU_BPJS_TK' headerText='No. Kartu BPJS TK' textAlign='Left' width=150></e-column>
              <e-column field='NO_KARTU_BPJS_KES' headerText='No. Kartu BPJS Kes' textAlign='Left' width=150></e-column>
              <e-column field='NO_KTP' headerText='No. KTP' textAlign='Left' width=150></e-column>
              <e-column field='NO_NPWP' headerText='No. NPWP' textAlign='Left' width=150></e-column>
              <e-column field='GOL_DR' headerText='Golongan Darah' textAlign='Left' width=150></e-column>
              <e-column field='STATUS' headerText='Status' textAlign='Left' width=150></e-column>
              <e-column field='STATUS_KERJA' headerText='Status Kerja' textAlign='Left' width=150></e-column>
              <e-column field='UKURAN_BAJU' headerText='Ukuran Baju' textAlign='Left' width=150></e-column>
              <e-column field='UKURAN_SEPATU' headerText='Ukuran Sepatu' textAlign='Left' width=150></e-column>
              <e-column field='PHK' headerText='PHK' textAlign='Left' width=150></e-column>
              <e-column field='TGL_PHK' headerText='Tgl PHK' textAlign='Left' width=150></e-column>
              <e-column field='KETERANGAN' headerText='Keterangan' textAlign='Left' width=150></e-column>
              <e-column field='PHOTO' headerText='Photo' textAlign='Left' width=150></e-column>
              <e-column field='NAMA_ISTRI_SUAMI' headerText='Nama Istri Suami' textAlign='Left' width=150></e-column>
              <e-column field='DibuatOleh' headerText='DibuatOleh' textAlign='Left' width=150></e-column>
              <e-column field='DibuatTgl' headerText='DibuatTgl' textAlign='Left' width=150></e-column>
              <e-column field='DiubahOleh' headerText='DiubahOleh' textAlign='Left' width=150></e-column>
              <e-column field='DiubahTgl' headerText='DiubahTgl' textAlign='Left' width=150></e-column>
            </e-columns>
          </ejs-grid>
        </v-col>
      </v-card>
    </v-col>
  </div>
</template>
<script>
import Vue from "vue";
import { GridPlugin, Page, Sort, Group, Resize, Toolbar, Search } from "@syncfusion/ej2-vue-grids";

Vue.use(GridPlugin);

export default {
  data() {
    return {
      date: new Date().toISOString().substr(0, 10),
      MenuTglMasuk: false,
      MenuTglLahir: false,
      MenuTglPHK: false,
      DialogTambahKaryawan: false,

      editedIndex: -1,
      defaultItem: {
        KODE_KARYAWAN: "",
        NAMA: "",
        NRK: "",
        KODE_JABATAN: "",
        POH: "",
        TGL_MASUK: "",
        TEMPAT_LAHIR: "",
        TGL_LAHIR: "",
        ALAMAT_KTP: "",
        ALAMAT_SEKARANG: "",
        NO_TLP: "",
        JENIS_KELAMIN: "",
        PENDIDIKAN_TERAKHIR: "",
        JURUSAN: "",
        AGAMA: "",
        SUKU: "",
        NO_REK_TABUNGAN: "",
        NO_KARTU_BPJS_TK: "",
        NO_KARTU_BPJS_KES: "",
        NO_KTP: "",
        NO_NPWP: "",
        GOL_DR: "",
        STATUS: "",
        STATUS_KERJA: "",
        UKURAN_BAJU: "",
        UKURAN_SEPATU: "",
        PHK: "",
        TGL_PHK: "",
        KETERANGAN: "",
        PHOTO: "",
        NAMA_ISTRI_SUAMI: "",
      },
      editedItem: {
        KODE_KARYAWAN: "",
        NAMA: "",
        NRK: "",
        KODE_JABATAN: "",
        POH: "",
        TGL_MASUK: "",
        TEMPAT_LAHIR: "",
        TGL_LAHIR: "",
        ALAMAT_KTP: "",
        ALAMAT_SEKARANG: "",
        NO_TLP: "",
        JENIS_KELAMIN: "",
        PENDIDIKAN_TERAKHIR: "",
        JURUSAN: "",
        AGAMA: "",
        SUKU: "",
        NO_REK_TABUNGAN: "",
        NO_KARTU_BPJS_TK: "",
        NO_KARTU_BPJS_KES: "",
        NO_KTP: "",
        NO_NPWP: "",
        GOL_DR: "",
        STATUS: "",
        STATUS_KERJA: "",
        UKURAN_BAJU: "",
        UKURAN_SEPATU: "",
        PHK: "",
        TGL_PHK: "",
        KETERANGAN: "",
        PHOTO: "",
        NAMA_ISTRI_SUAMI: "",
      },
      toolbarOptions: ['Search'],
      DataKaryawan: [],
      pageSettings: { pageSize: 5 },
    };
  },
  provide: {
    grid: [Page, Sort, Group, Resize, Toolbar, Search]
  },

  mounted(){
    this.editedItem.TGL_MASUK = this.date
    this.editedItem.TGL_LAHIR = this.date
    this.editedItem.TGL_PHK = this.date
  },

  computed: {
    formTitleKaryawan () {
      return this.editedIndex === -1 ? 'Tambah Karyawan' : 'Ubah Data Karyawan'
    },
  },
  
  watch: {
    DialogTambahKaryawan (val) {
      val || this.KeluarDialogKaryawan()
    },
    MenuTglLahir (val) {
      val && setTimeout(() => (this.$refs.picker.activePicker = 'YEAR'))
    },
  },

  methods: {
    Simpan(){
      if(this.formTitleKaryawan === "Tambah Karyawan"){
          // this.TambahData()
      }else{
          // this.UpdateData()
      }
      this.KeluarDialogKaryawan()    
    },

    KeluarDialogKaryawan () {
      this.DialogTambahKaryawan = false
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem)
        this.editedIndex = -1
        this.editedItem.TGL_MASUK = this.date
        this.editedItem.TGL_LAHIR = this.date
        this.editedItem.TGL_PHK = this.date
      })
    },

    Reset() {
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem)
      })
      
    },
  },
}
</script>


{% endraw %}