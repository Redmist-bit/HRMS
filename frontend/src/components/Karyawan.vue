<template>
  <div id="app">
    <v-col>
      <!-- Alert Data Tersimpan -->
      <v-alert style="position:fixed;z-index:2;right:20px;"
        dismissible
        color="red"
        border="left"
        elevation="4"
        colored-border
        v-model="Alert"
        transition="slide-x-transition"
      >
        Data Berhasil Disimpan
      </v-alert>

      <!-- Alert Data Sudah Terhapus -->
      <v-alert style="position:fixed;z-index:2;right:20px;"
        dismissible
        color="red"
        border="left"
        elevation="4"
        colored-border
        v-model="AlertDataTerhapus"
        transition="slide-x-transition"
      >
        Data Berhasil Dihapus
      </v-alert>

      <!-- Alert Data Berhasil Terubah -->
      <v-alert style="position:fixed;z-index:2;right:20px;"
        dismissible
        color="red"
        border="left"
        elevation="4"
        colored-border
        v-model="AlertBerhasilTerubah"
        transition="slide-x-transition"
      >
        Data Berhasil Diubah
      </v-alert>

      <v-card outlined class="rounded-lg elevation-10">
        <v-col>
          <v-toolbar
            dense
            flat
            color="dark"
            v-resize="onResize"
          >
            <v-toolbar-title>
              Data Karyawan
            </v-toolbar-title>
            <v-spacer></v-spacer>

            <div class="text-center mx-2">
              <v-menu
                v-model="MenuExport"
                :close-on-content-click="false"
                :nudge-width="1"
                offset-y
              >
                <template v-slot:activator="{ on, attrs }">
                  <!-- Btn Biasa -->
                  <v-btn
                    v-show="mobile == false"
                    text
                    v-bind="attrs"
                    v-on="on"
                    class="text-capitalize rounded-lg"
                  >
                    <v-icon class="mr-1">mdi-table-arrow-right</v-icon>
                    Export Data
                  </v-btn>

                  <!-- Btn Mode Mobile -->
                  <v-btn
                    v-show="mobile == true"
                    v-bind="attrs"
                    v-on="on"
                    class="mx-2"
                    small
                    text
                    fab
                  >
                    <v-icon>mdi-table-arrow-right</v-icon>
                  </v-btn>
                </template>

                <v-card outlined height="100" class="rounded-lg">
                  <v-list dense>
                    <!-- PDF -->
                    <v-list-item>
                      <v-btn
                        block
                        small
                        depressed
                        class="text-capitalize rounded-lg"
                      >
                        PDF
                      </v-btn>
                    </v-list-item>

                    <!-- EXCEL -->
                    <v-list-item>
                      <v-btn
                        block
                        small
                        depressed
                        class="text-capitalize rounded-lg"
                        @click.native="excelExport"
                      >
                        EXCEL
                      </v-btn>
                    </v-list-item>
                  </v-list>
                </v-card>
              </v-menu>
            </div>

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
                  v-show="mobile == false"
                  class="text-capitalize mx-n3 rounded-lg"
                  color="dark"
                  v-bind="attrs"
                  v-on="on"
                  text
                >
                  <v-icon class="mr-1">mdi-plus-thick</v-icon>
                  Tambah
                </v-btn>

                <v-btn 
                  class="mx-n3"
                  v-show="mobile == true"
                  v-bind="attrs"
                  v-on="on"
                  small
                  text
                  fab
                >
                  <v-icon>mdi-plus-thick</v-icon>
                </v-btn>
              </template>
              <v-card>
                <v-toolbar
                  flat
                >
                  <v-toolbar-title>
                    <v-icon class="mt-n2 mr-1">{{Icon}}</v-icon>
                    <span class="headline">{{ formTitleKaryawan }}</span>
                  </v-toolbar-title>
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
                  <div class="mt-4">
                    <v-row>
                      <!-- upload foto -->
                      <v-col cols="12" sm="4" md="3">
                        <v-card
                          outlined
                          class="rounded-lg pa-2"
                        >
                          <v-card
                            outlined
                            color="grey darken-1"
                            class="rounded-lg mb-2 fill-height"
                          >
                            <v-responsive :aspect-ratio="3/4">
                              <v-img
                                v-if="foto"
                                :src="foto"
                                class="d-flex flex-row rounded-lg fill-height"
                              >
                                <template v-slot:placeholder>
                                  <v-row
                                    class="fill-height ma-0"
                                    align="center"
                                    justify="center"
                                  >
                                    <v-progress-circular
                                      indeterminate
                                      color="grey lighten-5"
                                    ></v-progress-circular>
                                  </v-row>
                                </template>
                              </v-img>
                            </v-responsive>
                          </v-card>
                          <div class="form-group d-flex flex-row">
                            <input
                            id="upload-file"
                            type="file"
                            ref="fileupload"
                            class="custom-file-input rounded-lg col-12"
                            @change="fieldChange">
                          <!-- <img class="preview" :ref="'image'" /> -->
                          </div>
                        </v-card>
                      </v-col>

                      <!-- ----------------------------------------------- -->
                      <v-col cols="12" sm="8" md="9">
                        <v-toolbar flat dense outlined color="dark" class="rounded-lg mb-3">
                          <v-icon color="dark" class="mr-1">mdi-card-account-details</v-icon>
                          <span class="title d-inline-block text-truncate">Detail Karyawan</span>
                        </v-toolbar>
                        <v-card 
                          outlined
                          class="pa-3 rounded-lg"
                        >
                          <div class="mt-3">
                          <v-row>
                            <v-col cols="12" sm="6" md="4">
                              <v-text-field
                                dense
                                clearable
                                label="Nama"
                                color="dark"
                                v-model="editedItem.Nama"
                              ></v-text-field>
                            </v-col>

                            <v-col cols="12" sm="6" md="4">
                              <v-text-field
                                dense
                                clearable
                                label="NRK"
                                color="dark"
                                v-model="editedItem.Nrk"
                              ></v-text-field>
                            </v-col>

                            <v-col cols="12" sm="6" md="4">
                              <v-text-field
                                dense
                                label="Kode Jabatan"
                                color="dark"
                                v-model="editedItem.Kode_Jabatan"
                              ></v-text-field>
                            </v-col>

                            <v-col cols="12" sm="6" md="4">
                              <v-text-field
                                dense
                                clearable
                                label="POH"
                                color="dark"
                                v-model="editedItem.Poh"
                              ></v-text-field>
                            </v-col>

                            <v-col cols="12" sm="6" md="4">
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
                                    color="dark"
                                    readonly
                                    dense
                                    v-bind="attrs"
                                    v-on="on"
                                  ></v-text-field>
                                </template>
                                <v-date-picker
                                  v-model="editedItem.Tgl_Masuk"
                                  @input="MenuTglMasuk = false"
                                  year-icon="mdi-calendar-blank"
                                  color="red darken-4"
                                  locale="id"
                                ></v-date-picker>
                              </v-menu>
                            </v-col>

                            <v-col cols="12" sm="6" md="4">
                              <v-text-field
                                dense
                                clearable
                                label="Tempat Lahir"
                                color="dark"
                                v-model="editedItem.Tempat_Lahir"
                              ></v-text-field>
                            </v-col>

                            <v-col cols="12" sm="6" md="4">
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
                                    color="dark"
                                    readonly
                                    dense
                                    v-bind="attrs"
                                    v-on="on"
                                  ></v-text-field>
                                </template>
                                <v-date-picker
                                  v-model="editedItem.Tgl_Lahir"
                                  @input="MenuTglLahir = false"
                                  year-icon="mdi-calendar-blank"
                                  color="red darken-4"
                                  :max="new Date().toISOString().substr(0, 10)"
                                  min="1950-01-01"
                                  locale="id"
                                  ref="picker"
                                ></v-date-picker>
                              </v-menu>
                            </v-col>

                            <v-col cols="12" sm="6" md="4">
                              <v-text-field
                                dense
                                clearable
                                label="Alamat KTP"
                                color="dark"
                                v-model="editedItem.Alamat_Ktp"
                              ></v-text-field>
                            </v-col>

                            <v-col cols="12" sm="6" md="4">
                              <v-text-field
                                dense
                                clearable
                                label="Alamat Sekarang"
                                color="dark"
                                v-model="editedItem.Alamat_Sekarang"
                              ></v-text-field>
                            </v-col>

                            <v-col cols="12" sm="6" md="4">
                              <v-text-field
                                dense
                                clearable
                                label="No. Tlp"
                                color="dark"
                                v-model="editedItem.No_Tlp"
                              ></v-text-field>
                            </v-col>

                            <v-col cols="12" sm="6" md="4">
                              <v-combobox
                                dense
                                clearable
                                :items="['Laki-Laki','Perempuan']"
                                label="Jenis Kelamin"
                                color="dark"
                                v-model="editedItem.Jenis_Kelamin"
                              ></v-combobox>
                            </v-col>

                            <v-col cols="12" sm="6" md="4">
                              <v-text-field
                                dense
                                clearable
                                label="Pendidikan Terakhir"
                                color="dark"
                                v-model="editedItem.Pendidikan_Terakhir"
                              ></v-text-field>
                            </v-col>

                            <v-col cols="12" sm="6" md="4">
                              <v-text-field
                                dense
                                clearable
                                label="Jurusan"
                                color="dark"
                                v-model="editedItem.Jurusan"
                              ></v-text-field>
                            </v-col>

                            <v-col cols="12" sm="6" md="4">
                              <v-combobox
                                dense
                                clearable
                                :items="['Islam','Protestan','Katolik','Hindu','Buddha','Khonghucu']"
                                label="Agama"
                                color="dark"
                                v-model="editedItem.Agama"
                              ></v-combobox>
                            </v-col>

                            <v-col cols="12" sm="6" md="4">
                              <v-text-field
                                dense
                                clearable
                                label="Suku"
                                color="dark"
                                v-model="editedItem.Suku"
                              ></v-text-field>
                            </v-col>

                            <v-col cols="12" sm="6" md="4">
                              <v-text-field
                                dense
                                clearable
                                label="No. Rekening Tabungan"
                                color="dark"
                                v-model="editedItem.No_Rek_Tabungan"
                              ></v-text-field>
                            </v-col>

                            <v-col cols="12" sm="6" md="4">
                              <v-text-field
                                dense
                                clearable
                                label="No. Kartu BPJS TK"
                                color="dark"
                                v-model="editedItem.No_Kartu_Bpjs_Tk"
                              ></v-text-field>
                            </v-col>

                            <v-col cols="12" sm="6" md="4">
                              <v-text-field
                                dense
                                clearable
                                label="No. Kartu BPJS KES"
                                color="dark"
                                v-model="editedItem.No_Kartu_Bpjs_Kes"
                              ></v-text-field>
                            </v-col>

                            <v-col cols="12" sm="6" md="4">
                              <v-text-field
                                dense
                                clearable
                                label="No. KTP"
                                color="dark"
                                v-model="editedItem.No_Ktp"
                              ></v-text-field>
                            </v-col>

                            <v-col cols="12" sm="6" md="4">
                              <v-text-field
                                dense
                                clearable
                                label="No. NPWP"
                                color="dark"
                                v-model="editedItem.No_Npwp"
                              ></v-text-field>
                            </v-col>

                            <v-col cols="12" sm="6" md="4">
                              <v-combobox
                                dense
                                clearable
                                label="Golongan Darah"
                                color="dark"
                                :items="['A','B','AB','O']"
                                v-model="editedItem.Gol_Dr"
                              ></v-combobox>
                            </v-col>

                            <v-col cols="12" sm="6" md="4">
                              <v-text-field
                                dense
                                clearable
                                label="Status"
                                color="dark"
                                v-model="editedItem.Status"
                              ></v-text-field>
                            </v-col>

                            <v-col cols="12" sm="6" md="4">
                              <v-text-field
                                dense
                                clearable
                                label="Status Kerja"
                                color="dark"
                                v-model="editedItem.Status_Kerja"
                              ></v-text-field>
                            </v-col>

                            <v-col cols="12" sm="6" md="4">
                              <v-text-field
                                dense
                                clearable
                                label="Ukuran Baju"
                                color="dark"
                                v-model="editedItem.Ukuran_Baju"
                              ></v-text-field>
                            </v-col>

                            <v-col cols="12" sm="6" md="4">
                              <v-text-field
                                dense
                                clearable
                                label="Ukuran Sepatu"
                                color="dark"
                                v-model="editedItem.Ukuran_Sepatu"
                              ></v-text-field>
                            </v-col>

                            <v-col cols="12" sm="6" md="4">
                              <v-text-field
                                dense
                                clearable
                                label="PHK"
                                color="dark"
                                v-model="editedItem.Phk"
                              ></v-text-field>
                            </v-col>

                            <v-col cols="12" sm="6" md="4">
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
                                    color="dark"
                                    readonly
                                    dense
                                    v-bind="attrs"
                                    v-on="on"
                                  ></v-text-field>
                                </template>
                                <v-date-picker
                                  v-model="editedItem.Tgl_Phk"
                                  @input="MenuTglPHK = false"
                                  year-icon="mdi-calendar-blank"
                                  color="red darken-4"
                                  locale="id"
                                ></v-date-picker>
                              </v-menu>
                            </v-col>

                            <v-col cols="12" sm="6" md="4">
                              <v-text-field
                                dense
                                clearable
                                label="Keterangan"
                                color="dark"
                                v-model="editedItem.Keterangan"
                              ></v-text-field>
                            </v-col>

                            <v-col cols="12" sm="6" md="4">
                              <v-text-field
                                dense
                                clearable
                                label="Nama Istri Suami"
                                color="dark"
                                v-model="editedItem.Nama_Istri_Suami"
                              ></v-text-field>
                            </v-col>
                          </v-row>
                          </div>
                        </v-card>
                      </v-col>
                      <!-- --------------------------------- -->
                    </v-row>
                  </div>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                  <span class="d-inline-block text-truncate">
                    Status : <span>{{Status}}</span>
                  </span>
                <v-spacer></v-spacer>
                <v-tooltip bottom>
                  <template v-slot:activator="{ on, attrs }">
                  <v-btn
                    fab
                    text
                    small
                    v-bind="attrs"
                    v-on="on"
                    color="dark"
                    class="text-capitalize mx-4"
                    @click="Reset"
                  >
                    <v-icon>mdi-refresh</v-icon>
                  </v-btn>
                  </template>
                  <span>Refresh</span>
                </v-tooltip>


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
          ref='gridkaryawan'
            height="310"
            gridLines='Both'
            id="karyawanview"
            :dataSource="DataKaryawan"
            :allowPaging="true"
            :allowSorting='true'
            :allowResizing='true'
            :allowGrouping='true'
            :toolbar='toolbarOptions'
            :commandClick="commandClick"
            :pageSettings='pageSettings'
            :allowExcelExport='true'
          >
            <e-columns>
              <e-column headerText="Aksi" textAlign='Center' width="120" :commands="commands" :lockColumn='true' :customAttributes="customAttributes">
                <div class="btn-group">
                  <v-btn type="button" class="btn btn-default" (click)="prediemRowEdit($event)">
                    <i class="fa fa-pencil"></i>
                  </v-btn>
                  <v-btn type="button" class="btn btn-default" (click)="prediemRowDelete($event)">
                    <i class="fa fa-trash"></i>
                  </v-btn>
                </div>
              </e-column>
              <e-column field='KODE_KARYAWAN' headerText='Kode' textAlign='Left' width=110></e-column>
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
    <!-- dialog ganti gambar -->
    <v-dialog v-model="dialogchangefoto" max-width="405">
				<v-card class="rounded-lg">
					<v-card-title>
						<v-spacer></v-spacer>
						<span class="headline">Yakin Mengganti Foto Karyawan?</span> 
						<v-spacer></v-spacer>                   
					</v-card-title>
					
					<v-card-actions>
						<v-spacer></v-spacer>
						<v-btn
              class="text-capitalize"
							color="dark"
							text
							@click="GantiGambar = false, dialogchangefoto = false, foto = fotoTemp"
						>
							Tidak
						</v-btn>
						<v-btn
              class="text-capitalize"
							color="dark"
							text
							@click="gantifotokaryawan"
						>
							Ya
						</v-btn>
						<v-spacer></v-spacer>
					</v-card-actions>
				</v-card>
			</v-dialog>
  </div>
</template>
<script>
import Vue from "vue";
import { GridPlugin, Page, Sort, Group, Resize, Toolbar, Search,CommandColumn,ExcelExport  } from "@syncfusion/ej2-vue-grids";
import api from "@/services/http";
Vue.use(GridPlugin);

export default {
  data() {
    return {
      mobile:null,
      windowSize: {x: 0, y: 0},
      MenuExport: false,
      commands: [
        {
          buttonOption: { cssClass: "e-flat Edit", iconCss: "e-edit e-icons"}
        },
        {
          buttonOption: { cssClass:"e-flat Delete", iconCss: "e-delete e-icons"}
        }
      ],
      customAttributes : {class: 'customcss'},
      Alert:false,
      AlertDataTerhapus:false,
      AlertBerhasilTerubah:false,
      date: new Date().toISOString().substr(0, 10),
      MenuTglMasuk: false,
      MenuTglLahir: false,
      MenuTglPHK: false,
      user:[],
      token:null,
      KodeKaryawan:null,
      DialogTambahKaryawan: false,
      form: new FormData,
      editedIndex: -1,
      FotoKaryawan:[],
      fotoTemp:null,
      foto: null,
      dialogchangefoto:false,
      GantiGambar:null,
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
    grid: [Page, Sort, Group, Resize, Toolbar, CommandColumn, Search,ExcelExport]
  },

  mounted(){
    this.user = JSON.parse(localStorage.getItem('user'))
    this.token = localStorage.getItem('token')
    this.getdata()
    this.editedItem.Tgl_Masuk = this.date
    this.editedItem.Tgl_Lahir = this.date
    this.editedItem.Tgl_Phk = this.date
  },

  computed: {
    formTitleKaryawan () {
      return this.editedIndex === -1 ? 'Tambah Karyawan Baru' : 'Ubah Data Karyawan'
    },
    Icon () {
      return this.editedIndex === -1 ? 'mdi-plus-thick' : 'mdi-pencil'
    },
    Status () {
      return this.editedIndex === -1 ? 'Baru' : 'Ubah'
    },
  },
  
  watch: {
    windowSize(){
      if (this.windowSize.x < 450) {
        this.titleClass = "d-none"
        this.mobile = true
      }else{
        this.titleClass = "mr-4"
        this.mobile = false
      }
    },

    FotoKaryawan:{
      handler(){
      if (this.formTitleKaryawan == "Ubah Data Karyawan" && this.DialogTambahKaryawan == true) {
        this.dialogchangefoto = true
        // this.form.append('files',this.FotoKaryawan);
        // const config = { headers: { 'Content-Type': 'multipart/form-data' } };
        //   api.post("/karyawanFoto/"+this.KodeKaryawan+"?token="+this.token,this.form,config)
        //     .then((res) => {
        //       if(res){
        //         //do nothing
        //       }
        //       this.$refs.fileupload.value=null
        //       this.FotoKaryawan = []
        //       this.form = new FormData
        //       this.foto = null
        //     })
        //     .catch((error) => {
        //             console.log(JSON.stringify(error))
        //         })
        }
      }
    },
    DialogTambahKaryawan (val) {
      val || this.KeluarDialogKaryawan()
    },
    MenuTglLahir (val) {
      val && setTimeout(() => (this.$refs.picker.activePicker = 'YEAR'))
    },

    Alert(){
      this.AlertItem()
    },
    AlertDataTerhapus(){
      this.AlertItem()
    },
    AlertBerhasilTerubah(){
      this.AlertItem()
    },
  },

  methods: {
    onResize(){
      this.windowSize = { x: window.innerWidth, y: window.innerHeight }
    },

    Simpan(){
      if(this.formTitleKaryawan === "Tambah Karyawan Baru"){
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
          this.form.append('No_Tlp', this.editedItem.No_Tlp);
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
          this.form.append('DiBuatOleh', this.user.Kode);
          this.form.append('DiubahOleh', this.user.Kode); 
          this.Alert = true
          console.log(this.form)
          const config = { headers: { 'Content-Type': 'multipart/form-data' } };
          api.post("/karyawan?token="+this.token,this.form,config 
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
              if(res){
                this.getdata()
              }
              this.$refs.fileupload.value=null
              this.FotoKaryawan = []
              this.form = new FormData
              this.foto = null
            })
            .catch((error) => {
                    console.log(JSON.stringify(error))
                })
      }else if(this.formTitleKaryawan === "Ubah Data Karyawan"){
         api.put("/karyawan/" +this.KodeKaryawan+'?token='+this.token,{
            Nama: this.editedItem.Nama,
            Nrk: this.editedItem.Nrk,
            Kode_Jabatan: this.editedItem.Kode_Jabatan,
            Poh: this.editedItem.Poh,
            Tgl_Masuk: this.editedItem.Tgl_Masuk,
            Tempat_Lahir: this.editedItem.Tempat_Lahir,
            Tgl_Lahir: this.editedItem.Tgl_Lahir,
            Alamat_Ktp: this.editedItem.Alamat_Ktp,
            Alamat_Sekarang: this.editedItem.Alamat_Sekarang,
            No_Tlp: this.editedItem.No_Tlp,
            Jenis_Kelamin: this.editedItem.Jenis_Kelamin,
            Pendidikan_Terakhir: this.editedItem.Pendidikan_Terakhir,
            Jurusan: this.editedItem.Jurusan,
            Agama:this.editedItem.Agama,
            Suku: this.editedItem.Suku,
            No_Rek_Tabungan: this.editedItem.No_Rek_Tabungan,
            No_Kartu_Bpjs_Tk: this.editedItem.No_Kartu_Bpjs_Tk,
            No_Kartu_Bpjs_Kes: this.editedItem.No_Kartu_Bpjs_Kes,
            No_Npwp: this.editedItem.No_Npwp,
            No_Ktp: this.editedItem.No_Ktp,
            Gol_Dr: this.editedItem.Gol_Dr,
            Status: this.editedItem.Status,
            Status_Kerja: this.editedItem.Status_Kerja,
            Ukuran_Baju: this.editedItem.Ukuran_Baju,
            Ukuran_Sepatu: this.editedItem.Ukuran_Sepatu,
            Phk: this.editedItem.Phk,
            Tgl_Phk: this.editedItem.Tgl_Phk,
            Keterangan: this.editedItem.Keterangan,
            Nama_Istri_Suami: this.editedItem.Nama_Istri_Suami,
            DiubahOleh: this.user.Kode
					})
					.then((res) => {
						if (!res) {
							//do nothing
						}else{
              this.getdata()
              this.AlertBerhasilTerubah = true
						}
						
					})
      }
      this.$refs.fileupload.value=null
      this.FotoKaryawan = []
      this.form = new FormData
      this.foto = null
      this.KeluarDialogKaryawan()    
    },

    commandClick: function(args) {
      if (args.target.classList.contains("custombutton")){
        // let data = JSON.stringify(args.rowData);
		
        console.log(args.rowData);
      } else if (args.target.classList.contains("Delete")){
        var r = confirm("Yakin Hapus Data?");
        if (r == true) { 
          api
            .delete("/karyawan/"+args.rowData.KODE_KARYAWAN+'?token='+this.token)
            .then((res) =>{
              console.log(res);
              this.getdata()
              this.AlertDataTerhapus = true
            })
            .catch((err) => {
              console.log(err);
            });
        }
      } else if (args.target.classList.contains("Edit")){
        let data = args
            this.editedIndex = 1;
            console.log(data)
            this.editedItem = data.rowData
            this.DialogTambahKaryawan = true

          if (args.rowData.Aktif == 0) {
            this.dataTemp = args.rowData
            this.dialogAktifData = true
            }else{
                let data = args;
                this.editedIndex = 1;
                this.KodeKaryawan = data.rowData.KODE_KARYAWAN
                this.editedItem.Nama = data.rowData.NAMA
                this.editedItem.Nrk = data.rowData.NRK
                this.editedItem.Kode_Jabatan = data.rowData.KODE_JABATAN
                this.editedItem.Poh = data.rowData.POH
                this.editedItem.Tgl_Masuk = data.rowData.TGL_MASUK
                this.editedItem.Tempat_Lahir = data.rowData.TEMPAT_LAHIR
                this.editedItem.Tgl_Lahir = data.rowData.TGL_LAHIR
                this.editedItem.Alamat_Ktp = data.rowData.ALAMAT_KTP
                this.editedItem.Alamat_Sekarang = data.rowData.ALAMAT_SEKARANG
                this.editedItem.No_Tlp = data.rowData.NO_TLP
                this.editedItem.Jenis_Kelamin = data.rowData.JENIS_KELAMIN
                this.editedItem.Pendidikan_Terakhir = data.rowData.PENDIDIKAN_TERAKHIR
                this.editedItem.Jurusan = data.rowData.JURUSAN
                this.editedItem.Agama = data.rowData.AGAMA
                this.editedItem.Suku = data.rowData.SUKU
                this.editedItem.No_Rek_Tabungan = data.rowData.NO_REK_TABUNGAN
                this.editedItem.No_Kartu_Bpjs_Tk = data.rowData.NO_KARTU_BPJS_TK
                this.editedItem.No_Kartu_Bpjs_Kes = data.rowData.NO_KARTU_BPJS_KES
                this.editedItem.No_Ktp = data.rowData.NO_KTP
                this.editedItem.No_Npwp = data.rowData.NO_NPWP
                this.editedItem.Gol_Dr = data.rowData.GOL_DR
                this.editedItem.Status = data.rowData.STATUS
                this.editedItem.Status_Kerja = data.rowData.STATUS_KERJA
                this.editedItem.Ukuran_Baju = data.rowData.UKURAN_BAJU
                this.editedItem.Ukuran_Sepatu = data.rowData.UKURAN_SEPATU
                this.editedItem.Phk = data.rowData.PHK
                this.editedItem.Tgl_Phk = data.rowData.TGL_PHK
                this.editedItem.Keterangan = data.rowData.KETERANGAN
                this.editedItem.Nama_Istri_Suami = data.rowData.NAMA_ISTRI_SUAMI
                this.foto = "http://"+window.location.hostname+":8000"+data.rowData.PHOTO
                this.fotoTemp = "http://"+window.location.hostname+":8000"+data.rowData.PHOTO
                console.log(this.fotoTemp)
                // this.dialogWO = true;
            }
      }
    },
    gantifotokaryawan(){
    this.dialogchangefoto = false
    this.form.append('files',this.FotoKaryawan);
      const config = { headers: { 'Content-Type': 'multipart/form-data' } };
        api.post("/karyawanFoto/"+this.KodeKaryawan+"?token="+this.token,this.form,config)
          .then((res) => {
            console.log(res.data.foto)
            if(res){
              //do nothing
            this.getdata()
            this.foto = "http://"+window.location.hostname+":8000"+res.data.foto
            this.fotoTemp = "http://"+window.location.hostname+":8000"+res.data.foto
            }
            this.$refs.fileupload.value=null
            this.form = new FormData
          })
          .catch((error) => {
                  console.log(JSON.stringify(error))
              })
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
    excelExport(){
      this.$refs.gridkaryawan.excelExport();
      console.log(this.$refs.gridkaryawan)
      // let data = document.getElementById('karyawanview').ej2_instances[0];
      // console.log(data)
      // data.excelExport();
    },

    KeluarDialogKaryawan () {
      this.DialogTambahKaryawan = false
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem)
        this.editedIndex = -1
        this.foto = null
        this.editedItem.Tgl_Masuk = this.date
        this.editedItem.Tgl_Lahir = this.date
        this.editedItem.Tgl_Phk = this.date
      })
    },

    getdata(){
      api.get('/karyawan?token='+this.token).then(
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

    AlertItem(){
      window.setInterval(() => {
        this.Alert = false;
        this.AlertDataTerhapus = false;
        this.AlertBerhasilTerubah = false;
      }, 3000)
    },
  },
}
</script>

<style scoped>
.custom-file-input {
  border: 1px solid #ccc;
  display: inline-block solid #ccc;
  padding: 6px 6px 6px;
  cursor: pointer;
}

.e-grid .e-rowcell.customcss{
  background-color: #d6d6d6;
}
.e-grid .e-headercell.customcss{
  background-color: #ecedee;
}
</style>


{% endraw %}