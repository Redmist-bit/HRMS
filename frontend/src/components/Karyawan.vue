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
                      <v-col cols="12" sm="12" md="12">
                        <div class="pa-3">
                          <!-- <legend>Upload foto</legend> -->
                          <strong>Select Image :</strong>
                            <!-- <div class="form-group" v-for="(image, key) in attachments" :key="key"> -->
                              <div class="form-group">
                                <input id="upload-file" type="file" ref="fileupload" class="custom-file-input" @change="fieldChange">
                              <!-- <img class="preview" :ref="'image'" /> -->

                            </div>
                            <!-- <button class="btn btn-primary" @click="uploadFile">Submit</button> -->
                        </div>
                        <v-card 
                          outlined
                          max-height="250"
                          max-width="180"
                          class="rounded-lg elevation-2"
                        >
                          <v-responsive :aspect-ratio="9/16">
                          <v-img v-if="foto" :src="foto"></v-img>
                            <!-- <v-img
                              max-height="250"
                              max-width="150"
                            >
                            </v-img> -->
                          </v-responsive>
                        </v-card>
                      </v-col>

                      <v-col cols="12" sm="6" md="3">
                        <v-text-field
                          dense
                          color="grey darken-2"
                          label="Kode Karyawan"
                          v-model="editedItem.Kode_Karyawan"
                        ></v-text-field>
                      </v-col>

                      <v-col cols="12" sm="6" md="3">
                        <v-text-field
                          dense
                          clearable
                          label="Nama"
                          color="grey darken-2"
                          v-model="editedItem.Nama"
                        ></v-text-field>
                      </v-col>

                      <v-col cols="12" sm="6" md="3">
                        <v-text-field
                          dense
                          clearable
                          label="NRK"
                          color="grey darken-2"
                          v-model="editedItem.Nrk"
                        ></v-text-field>
                      </v-col>

                      <v-col cols="12" sm="6" md="3">
                        <v-text-field
                          dense
                          label="Kode Jabatan"
                          color="grey darken-2"
                          v-model="editedItem.Kode_Jabatan"
                        ></v-text-field>
                      </v-col>

                      <v-col cols="12" sm="6" md="3">
                        <v-text-field
                          dense
                          clearable
                          label="POH"
                          color="grey darken-2"
                          v-model="editedItem.Poh"
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
                              v-model="editedItem.Tgl_Masuk"
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
                            v-model="editedItem.Tgl_Masuk"
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
                          v-model="editedItem.Tempat_Lahir"
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
                              v-model="editedItem.Tgl_Lahir"
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
                            v-model="editedItem.Tgl_Lahir"
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
                          v-model="editedItem.Alamat_Ktp"
                        ></v-text-field>
                      </v-col>

                      <v-col cols="12" sm="6" md="3">
                        <v-text-field
                          dense
                          clearable
                          label="Alamat Sekarang"
                          color="grey darken-2"
                          v-model="editedItem.Alamat_Sekarang"
                        ></v-text-field>
                      </v-col>

                      <v-col cols="12" sm="6" md="3">
                        <v-text-field
                          dense
                          clearable
                          label="No. Tlp"
                          color="grey darken-2"
                          v-model="editedItem.No_Tlp"
                        ></v-text-field>
                      </v-col>

                      <v-col cols="12" sm="6" md="3">
                        <v-combobox
                          dense
                          clearable
                          :items="['Laki-Laki','Perempuan']"
                          label="Jenis Kelamin"
                          color="grey darken-2"
                          v-model="editedItem.Jenis_Kelamin"
                        ></v-combobox>
                      </v-col>

                      <v-col cols="12" sm="6" md="3">
                        <v-text-field
                          dense
                          clearable
                          label="Pendidikan Terakhir"
                          color="grey darken-2"
                          v-model="editedItem.Pendidikan_Terakhir"
                        ></v-text-field>
                      </v-col>

                      <v-col cols="12" sm="6" md="3">
                        <v-text-field
                          dense
                          clearable
                          label="Jurusan"
                          color="grey darken-2"
                          v-model="editedItem.Jurusan"
                        ></v-text-field>
                      </v-col>

                      <v-col cols="12" sm="6" md="3">
                        <v-combobox
                          dense
                          clearable
                          :items="['Islam','Protestan','Katolik','Hindu','Buddha','Khonghucu']"
                          label="Agama"
                          color="grey darken-2"
                          v-model="editedItem.Agama"
                        ></v-combobox>
                      </v-col>

                      <v-col cols="12" sm="6" md="3">
                        <v-text-field
                          dense
                          clearable
                          label="Suku"
                          color="grey darken-2"
                          v-model="editedItem.Suku"
                        ></v-text-field>
                      </v-col>

                      <v-col cols="12" sm="6" md="3">
                        <v-text-field
                          dense
                          clearable
                          label="No. Rekening Tabungan"
                          color="grey darken-2"
                          v-model="editedItem.No_Rek_Tabungan"
                        ></v-text-field>
                      </v-col>

                      <v-col cols="12" sm="6" md="3">
                        <v-text-field
                          dense
                          clearable
                          label="No. Kartu BPJS TK"
                          color="grey darken-2"
                          v-model="editedItem.No_Kartu_Bpjs_Tk"
                        ></v-text-field>
                      </v-col>

                      <v-col cols="12" sm="6" md="3">
                        <v-text-field
                          dense
                          clearable
                          label="No. Kartu BPJS KES"
                          color="grey darken-2"
                          v-model="editedItem.No_Kartu_Bpjs_Kes"
                        ></v-text-field>
                      </v-col>

                      <v-col cols="12" sm="6" md="3">
                        <v-text-field
                          dense
                          clearable
                          label="No. KTP"
                          color="grey darken-2"
                          v-model="editedItem.No_Ktp"
                        ></v-text-field>
                      </v-col>

                      <v-col cols="12" sm="6" md="3">
                        <v-text-field
                          dense
                          clearable
                          label="No. NPWP"
                          color="grey darken-2"
                          v-model="editedItem.No_Npwp"
                        ></v-text-field>
                      </v-col>

                      <v-col cols="12" sm="6" md="3">
                        <v-text-field
                          dense
                          clearable
                          label="Golongan Darah"
                          color="grey darken-2"
                          v-model="editedItem.Gol_Dr"
                        ></v-text-field>
                      </v-col>

                      <v-col cols="12" sm="6" md="3">
                        <v-text-field
                          dense
                          clearable
                          label="Status"
                          color="grey darken-2"
                          v-model="editedItem.Status"
                        ></v-text-field>
                      </v-col>

                      <v-col cols="12" sm="6" md="3">
                        <v-text-field
                          dense
                          clearable
                          label="Status Kerja"
                          color="grey darken-2"
                          v-model="editedItem.Status_Kerja"
                        ></v-text-field>
                      </v-col>

                      <v-col cols="12" sm="6" md="3">
                        <v-text-field
                          dense
                          clearable
                          label="Ukuran Baju"
                          color="grey darken-2"
                          v-model="editedItem.Ukuran_Baju"
                        ></v-text-field>
                      </v-col>

                      <v-col cols="12" sm="6" md="3">
                        <v-text-field
                          dense
                          clearable
                          label="Ukuran Sepatu"
                          color="grey darken-2"
                          v-model="editedItem.Ukuran_Sepatu"
                        ></v-text-field>
                      </v-col>

                      <v-col cols="12" sm="6" md="3">
                        <v-text-field
                          dense
                          clearable
                          label="PHK"
                          color="grey darken-2"
                          v-model="editedItem.Phk"
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
                              v-model="editedItem.Tgl_Phk"
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
                            v-model="editedItem.Tgl_Phk"
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
                          v-model="editedItem.Keterangan"
                        ></v-text-field>
                      </v-col>

                      <v-col cols="12" sm="6" md="3">
                        <v-text-field
                          dense
                          clearable
                          label="Photo"
                          color="grey darken-2"
                          v-model="editedItem.Photo"
                        ></v-text-field>
                      </v-col>

                      <v-col cols="12" sm="6" md="3">
                        <v-text-field
                          dense
                          clearable
                          label="Nama Istri Suami"
                          color="grey darken-2"
                          v-model="editedItem.Nama_Istri_Suami"
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
              <e-column field='DiBuatOleh' headerText='DibuatOleh' textAlign='Left' width=150></e-column>
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
import api from "@/services/http";
Vue.use(GridPlugin);

export default {
  data() {
    return {
      date: new Date().toISOString().substr(0, 10),
      MenuTglMasuk: false,
      MenuTglLahir: false,
      MenuTglPHK: false,
      DialogTambahKaryawan: false,
      form: new FormData,
      editedIndex: -1,
      FotoKaryawan:[],
      foto: null,
      defaultItem: {
        Kode_Karyawan: "",
        Nama: "",
        Nrk: "",
        Kode_Jabatan: "",
        Poh: "",
        Tgl_Masuk: "",
        Tempat_Lahir: "",
        Tgl_Lahir: "",
        Alamat_Ktp: "",
        Alamat_Sekarang: "",
        No_Tlp: "",
        Jenis_Kelamin: "",
        Pendidikan_Terakhir: "",
        Jurusan: "",
        Agama: "",
        Suku: "",
        No_Rek_Tabungan: "",
        No_Kartu_Bpjs_Tk: "",
        No_Kartu_Bpjs_Kes: "",
        No_Ktp: "",
        No_Npwp: "",
        Gol_Dr: "",
        Status: "",
        Status_Kerja: "",
        Ukuran_Baju: "",
        Ukuran_Sepatu: "",
        Phk: "",
        Tgl_Phk: "",
        Keterangan: "",
        Photo: "",
        Nama_Istri_Suami: "",
      },
      editedItem: {
        Kode_Karyawan: "",
        Nama: "",
        Nrk: "",
        Kode_Jabatan: "",
        Poh: "",
        Tgl_Masuk: "",
        Tempat_Lahir: "",
        Tgl_Lahir: "",
        Alamat_Ktp: "",
        Alamat_Sekarang: "",
        No_Tlp: "",
        Jenis_Kelamin: "",
        Pendidikan_Terakhir: "",
        Jurusan: "",
        Agama: "",
        Suku: "",
        No_Rek_Tabungan: "",
        No_Kartu_Bpjs_Tk: "",
        No_Kartu_Bpjs_Kes: "",
        No_Ktp: "",
        No_Npwp: "",
        Gol_Dr: "",
        Status: "",
        Status_Kerja: "",
        Ukuran_Baju: "",
        Ukuran_Sepatu: "",
        Phk: "",
        Tgl_Phk: "",
        Keterangan: "",
        Photo: "",
        Nama_Istri_Suami: "",
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
    this.getdata()
    this.editedItem.Tgl_Masuk = this.date
    this.editedItem.Tgl_Lahir = this.date
    this.editedItem.Tgl_Phk = this.date
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
          this.form.append('files',this.FotoKaryawan);
          this.form.append('Nama', this.editedItem.Nama);
          this.form.append('Nrk', this.editedItem.Nrk);
          this.form.append('Kode_Jabatan', this.editedItem.Kode_Jabatan);
          this.form.append('Poh', this.editedItem.Poh);
          this.form.append('Tgl_Masuk', this.editedItem.Tgl_Masuk);
          this.form.append('Tempat_Lahir', this.editedItem.Tempat_Lahir);
          this.form.append('Tgl_Lahir', this.editedItem.Tgl_Lahir);
          this.form.append('Alamat_Ktp', this.editedItem.Alamat_Ktp);
          this.form.append('Alamat_Sekarang', this.editedItem.Alamat_Sekarang);
          this.form.append('No_Telp', this.editedItem.No_Telp);
          this.form.append('Jenis_Kelamin', this.editedItem.Jenis_Kelamin);
          this.form.append('Pendidikan_Terakhir', this.editedItem.Pendidikan_Terakhir);
          this.form.append('Jurusan', this.editedItem.Jurusan);
          this.form.append('Agama', this.editedItem.Agama);
          this.form.append('Suku', this.editedItem.Suku);
          this.form.append('No_Rek_Tabungan', this.editedItem.No_Rek_Tabungan);
          this.form.append('No_Kartu_Bpjs_Tk', this.editedItem.No_Kartu_Bpjs_Tk);
          this.form.append('No_Kartu_Bpjs_Kes', this.editedItem.No_Kartu_Bpjs_Kes);
          this.form.append('No_Ktp', this.editedItem.No_Ktp);
          this.form.append('No_Npwp', this.editedItem.No_Npwp);
          this.form.append('Gol_Dr', this.editedItem.Gol_Dr);
          this.form.append('Status', this.editedItem.Status);
          this.form.append('Status_Kerja', this.editedItem.Status_Kerja);
          this.form.append('Ukuran_Baju', this.editedItem.Ukuran_Baju);
          this.form.append('Ukuran_Sepatu', this.editedItem.Ukuran_Sepatu);
          this.form.append('Phk', this.editedItem.Phk);
          this.form.append('Tgl_Phk', this.editedItem.Tgl_Phk);
          this.form.append('Keterangan', this.editedItem.Keterangan);
          this.form.append('Nama_Istri_Suami', this.editedItem.Nama_Istri_Suami);
          this.form.append('DiBuatOleh', this.editedItem.DiBuatOleh);
          this.form.append('DiubahOleh', this.editedItem.DiubahOleh); 
          console.log(this.form)
          const config = { headers: { 'Content-Type': 'multipart/form-data' } };
          api.post("/karyawan",this.form,config 
          // Nama: this.editedItem.Nama,
          // Nrk: this.editedItem.Nrk,
          // Kode_Jabatan: this.editedItem.Kode_Jabatan,
          // Poh: this.editedItem.Poh,
          // Tgl_Masuk: this.editedItem.Tgl_Masuk,
          // Tempat_Lahir: this.editedItem.Tempat_Lahir,
          // Tgl_lahir: this.editedItem.Tgl_lahir,
          // Alamat_KTP: this.editedItem.Alamat_KTP,
          // Alamat_Sekarang: this.editedItem.Alamat_Sekarang,
          // No_Telp: this.editedItem.No_Telp,
          // Jenis_Kelamin: this.editedItem.Jenis_Kelamin,
          // Pendidikan_Terakhir: this.editedItem.Pendidikan_Terakhir,
          // Jurusan: this.editedItem.Jurusan,
          // Agama:this.editedItem.Agama,
          // Suku: this.editedItem.Suku,
          // No_Rek_Tabungan: this.editedItem.No_Rek_Tabungan,
          // No_Kartu_BPJS_TK: this.editedItem.No_Kartu_BPJS_TK,
          // No_Kartu_BPJS_KES: this.editedItem.No_Kartu_BPJS_KES,
          // No_NPWP: this.editedItem.No_NPWP,
          // Gol_Dr: this.editedItem.Gol_Dr,
          // Status: this.editedItem.Status,
          // Status_Kerja: this.editedItem.Status_Kerja,
          // Ukuran_Baju: this.editedItem.Ukuran_Baju,
          // Ukuran_Sepatu: this.editedItem.Ukuran_Sepatu,
          // Phk: this.editedItem.Phk,
          // Tgl_Phk: this.editedItem.Tgl_Phk,
          // Keterangan: this.editedItem.Keterangan,
          // Nama_Istri_Suami: this.editedItem.Nama_Istri_Suami,
          // DiBuatOleh: this.editedItem.DiBuatOleh,
          // DiubahOleh: this.editedItem.DiubahOleh
            )
            .then((res) => {
              console.log(res)
              this.$refs.fileupload.value=null
              this.FotoKaryawan = []
              this.form = new FormData
              this.foto = null
            })
            .catch((error) => {
                    console.log(JSON.stringify(error))
                })
      }else{
          // this.UpdateData()
      }
      this.KeluarDialogKaryawan()    
    },

    fieldChange(e){
      console.log(e)
				let selectedFiles=e.target.files;
				if(!selectedFiles.length){
					return false;
				}
				for(let i=0;i<selectedFiles.length;i++){
					this.FotoKaryawan = selectedFiles[0];
				}
				// for (let i = 0; i < this.FotoKaryawan.length; i++) {
				// 	let reader = new FileReader();// eslint-disable-next-line
				// 	reader.onload = (e) => { 
				// 	this.foto = e.target.files; 
				// 	// console.log(this.$refs.attachments[i].src);
					
				// 	};
          const file = this.FotoKaryawan;
          this.foto = URL.createObjectURL(file);
					// reader.readAsDataURL(this.FotoKaryawan[0]);
					
				// }
				console.log(this.FotoKaryawan);
      // console.log(e)
      // let selectedFiles=e.target.files;
      // if(!selectedFiles.length){
      //   return false;
      // }
      // // for(let i=0;i<selectedFiles.length;i++){
      // //   this.FotoKaryawan.push(selectedFiles[i]);
      // // }
			// 		this.FotoKaryawan.push(selectedFiles[0])
      // // for (let i = 0; i < this.FotoKaryawan.length; i++) {
      // const file = selectedFiles[0];
      // this.foto = URL.createObjectURL(file);
      // console.log('awowowo',this.FotoKaryawan);
    },

    KeluarDialogKaryawan () {
      this.DialogTambahKaryawan = false
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem)
        this.editedIndex = -1
        this.editedItem.Tgl_Masuk = this.date
        this.editedItem.Tgl_Lahir = this.date
        this.editedItem.Tgl_Phk = this.date
      })
    },

    getdata(){
      api.get('/karyawan').then(
				res => {
					console.log(res);
          this.DataKaryawan = res.data
				},
				err => {
					console.log(err);
				}
			)
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