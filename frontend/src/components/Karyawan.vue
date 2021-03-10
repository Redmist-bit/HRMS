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
                                <input id="upload-file" type="file" ref="fileupload" multiple class="custom-file-input" @change="fieldChange">
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
              <e-column field='Kode_Karyawan' headerText='Kode' textAlign='Left' width=150></e-column>
              <e-column field='Nama' headerText='Nama' width=300></e-column>
              <e-column field='Nrk' headerText='NRK' textAlign='Left' width=150></e-column>
              <e-column field='Kode_Jabatan' headerText='Kode Jabatan' textAlign='Left' width=150></e-column>
              <e-column field='Poh' headerText='POH' textAlign='Left' width=150></e-column>
              <e-column field='Tgl_Masuk' headerText='Tgl Masuk' textAlign='Left' width=150></e-column>
              <e-column field='Tempat_Lahir' headerText='Tempat Lahir' textAlign='Left' width=150></e-column>
              <e-column field='Tgl_Lahir' headerText='Tgl Lahir' textAlign='Left' width=150></e-column>
              <e-column field='Alamat_Ktp' headerText='Alamat KTP' textAlign='Left' width=200></e-column>
              <e-column field='Alamat_Sekarang' headerText='Alamat Sekarang' textAlign='Left' width=200></e-column>
              <e-column field='No_Tlp' headerText='No. Tlp' textAlign='Left' width=150></e-column>
              <e-column field='Jenis_Kelamin' headerText='Jenis Kelamin' textAlign='Left' width=150></e-column>
              <e-column field='Pendidikan_Terakhir' headerText='Pendidikan Terakhir' textAlign='Left' width=150></e-column>
              <e-column field='Jurusan' headerText='Jurusan' textAlign='Left' width=150></e-column>
              <e-column field='Agama' headerText='Agama' textAlign='Left' width=150></e-column>
              <e-column field='Suku' headerText='Suku' textAlign='Left' width=150></e-column>
              <e-column field='No_Rek_Tabungan' headerText='No. RekTabungan' textAlign='Left' width=150></e-column>
              <e-column field='No_Kartu_Bpjs_Tk' headerText='No. Kartu BPJS TK' textAlign='Left' width=150></e-column>
              <e-column field='No_Kartu_Bpjs_Kes' headerText='No. Kartu BPJS Kes' textAlign='Left' width=150></e-column>
              <e-column field='No_Ktp' headerText='No. KTP' textAlign='Left' width=150></e-column>
              <e-column field='No_Npwp' headerText='No. NPWP' textAlign='Left' width=150></e-column>
              <e-column field='Gol_Dr' headerText='Golongan Darah' textAlign='Left' width=150></e-column>
              <e-column field='Status' headerText='Status' textAlign='Left' width=150></e-column>
              <e-column field='Status_Kerja' headerText='Status Kerja' textAlign='Left' width=150></e-column>
              <e-column field='Ukuran_Baju' headerText='Ukuran Baju' textAlign='Left' width=150></e-column>
              <e-column field='Ukuran_Sepatu' headerText='Ukuran Sepatu' textAlign='Left' width=150></e-column>
              <e-column field='Phk' headerText='PHK' textAlign='Left' width=150></e-column>
              <e-column field='Tgl_Phk' headerText='Tgl PHK' textAlign='Left' width=150></e-column>
              <e-column field='Keterangan' headerText='Keterangan' textAlign='Left' width=150></e-column>
              <e-column field='Photo' headerText='Photo' textAlign='Left' width=150></e-column>
              <e-column field='Nama_Istri_Suami' headerText='Nama Istri Suami' textAlign='Left' width=150></e-column>
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
        //   api.post("/karyawan", {
        //   Nama: this.editedItem.Nama,
        //   Kategori: this.editedItem.Kategori,
        //   SubKategori: this.editedItem.SubKategori,
        //   Grup: this.editedItem.Grup,
        //   SubGrup: this.editedItem.SubGrup,
        //   Memo: this.editedItem.Memo,
        //   Merk: this.editedItem.Merk,
        //   Type: this.editedItem.Type,
        //   PartNumber1: this.editedItem.PartNumber1,
        //   PartNumber2: this.editedItem.PartNumber2,
        //   Dimensi: this.editedItem.Dimensi,
        //   Kendaraan: this.editedItem.Kendaraan,
        //   DiBuatOleh:'',
        //   // DiBuatTgl:today,
        //   DiubahOleh:'',
        //   // DiubahTgl:today,
        //   Aktif: true,
        //   Gudang: 'TA1'
        //     })
        //     .then((res) => {
        //   this.Nama = "";
        //   this.Kategori = "";
        //   this.SubKategori = "";
        //   this.Grup = "";
        //   this.SubGrup = "";
        //   this.Memo = "";
        //   this.Merk = "";
        //   this.Type = "";
        //   this.PartNumber1 = "";
        //   this.PartNumber2 = "";
        //   this.Dimensi = "";
        //   this.Kendaraan = "";
        //   this.Aktif = "";
              
        //   console.log(res);
        //   this.getDataTambahpro();
        // // })
        //   this.Upload()
        // this.closeproduk();
        //     })
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
        this.attachments.push(selectedFiles[i]);
      }
      for (let i = 0; i < this.attachments.length; i++) {
        let reader = new FileReader();// eslint-disable-next-line
        reader.onload = (e) => { 
        this.$refs.image[i].src = reader.result; 
        // console.log(this.$refs.attachments[i].src);
        
        };

        
        reader.readAsDataURL(this.attachments[i]);
        
      }
      console.log(this.attachments);
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

    Reset() {
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem)
      })
      
    },
  },
}
</script>


{% endraw %}