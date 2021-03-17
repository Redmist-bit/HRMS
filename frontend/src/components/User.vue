<template>
  <div id="app">
    <v-overlay :value="loading">
      <v-progress-circular
        indeterminate
        size="64"
      ></v-progress-circular>
    </v-overlay>
    <v-alert type="error" v-show="this.valid == false">
      Kamu Tidak punya Akses Ke halaman ini
    </v-alert>
    <v-col v-show="this.valid == true">
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
              Data Pengguna
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
                  <!-- Btn Export Mode Biasa -->
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
                        @click.native="PdfExport"
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

              <!-- Btn Export Dialog Mode Mobile -->
              <v-dialog
                v-model="DialogPilihExport"
                max-width="200"
              >
                <template v-slot:activator="{ on, attrs }">
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
                <v-card class="rounded-lg">
                  <v-toolbar dense>
                    <v-layout justify-center>
                      <v-toolbar-title>
                        Pilih Export File
                      </v-toolbar-title>
                    </v-layout>
                  </v-toolbar>
                  <v-card class="pa-2">
                    <v-btn outlined block class="text-capitalize rounded-lg" @click.native="PdfExport">
                      Pdf
                      <v-icon class="ml-1">mdi-adobe-acrobat</v-icon>
                    </v-btn>

                    <v-btn outlined block class="text-capitalize rounded-lg mt-2" @click.native="excelExport">
                      Excel
                      <v-icon class="ml-1">mdi-microsoft-excel</v-icon>
                    </v-btn>
                  </v-card>
                </v-card>
              </v-dialog>
            </div>

            <!-- Dialog Tambah User -->
            <v-dialog
              v-model="DialogTambahUser"
              max-width="600px"
              scrollable
              persistent
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
                    <span class="headline">{{ formTitleUser }}</span>
                  </v-toolbar-title>
                  <v-spacer></v-spacer>
                  <v-btn
                    fab
                    text
                    small
                    @click="KeluarDialogUser"
                  >
                    <v-icon>mdi-window-close</v-icon>
                  </v-btn>
                </v-toolbar>
                <v-divider></v-divider>
                
                <v-card-text>
                  <div class="mt-4">
                    <v-row>
                      <v-col cols="12" sm="12" md="12">
                        <v-card 
                          outlined
                          class="pa-3 rounded-lg"
                        >
                          <div class="mt-3">
                            <v-row>
                              <v-col cols="12" sm="6" md="6">
                                <v-text-field
                                  dense
                                  clearable
                                  label="Kode"
                                  color="dark"
                                  v-model="Kode"
                                  @blur="cariKode(Kode)"
                                ></v-text-field>
                              </v-col>

                              <v-col cols="12" sm="6" md="6">
                                <v-text-field
                                  dense
                                  clearable
                                  label="Nama"
                                  color="dark"
                                  v-model="editedItem.Nama"
                                  :disabled="textAktif"
                                ></v-text-field>
                              </v-col>

                               <v-col cols="12" sm="6" md="6">
                                <v-combobox
                                dense
                                clearable
                                :items="DataUser"
                                label="User Menu"
                                color="dark"
                                item-text="UserMenu"
                                item-value="UserMenu"
                                return-object
                                v-model="editedItem.UserMenu"
                                :disabled="textAktif"
                                  ></v-combobox>
                              </v-col>

                              <v-col cols="12" sm="6" md="6">
                                <v-text-field
                                  dense
                                  clearable
                                  label="Password"
                                  color="dark"
                                  v-model="editedItem.password"
                                  v-show="editedIndex == -1"
                                  :disabled="textAktif"
                                ></v-text-field>

                                <v-text-field
                                  dense
                                  clearable
                                  label="Password Lama"
                                  color="dark"
                                  type="password"
                                  disabled
                                  v-model="editedItem.password"
                                  v-show="editedIndex == 1"
                                ></v-text-field>
                              </v-col>

                              <v-col cols="12" sm="6" md="6">
                                <v-text-field
                                  dense
                                  clearable
                                  label="Password Baru"
                                  color="dark"
                                  v-model="passbaru"
                                  v-show="editedIndex == 1"
                                ></v-text-field>
                              </v-col>

                              <v-col cols="12" sm="6" md="6">
                                <v-text-field
                                  dense
                                  clearable
                                  label="Ulangi Password Baru"
                                  color="dark"
                                  v-model="verifpassbaru"
                                  v-show="editedIndex == 1"
                                ></v-text-field>
                              </v-col>
                            </v-row>
                          </div>
                        </v-card>
                      </v-col>
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
            ref='griduser'
            height="310"
            gridLines='Both'
            id="userview"
            :dataSource="DataUser"
            :allowPaging="true"
            :allowSorting='true'
            :allowResizing='true'
            :allowGrouping='true'
            :toolbar='toolbarOptions'
            :commandClick="commandClick"
            :pageSettings='pageSettings'
            :allowExcelExport='true'
            :allowPdfExport='true'
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
              <e-column field='Kode' headerText='Kode' textAlign='Left' width=110></e-column>
              <e-column field='Nama' headerText='Nama' width=300></e-column>
              <e-column field='password' headerText='Password' width=150 :visible='false'></e-column>
              <e-column field='UserMenu' headerText='UserMenu' textAlign='Left' width=150></e-column>
              <e-column field='DibuatTgl' headerText='DibuatTgl' textAlign='Left' width=150></e-column>
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
import { GridPlugin, Page, Sort, Group, Resize, Toolbar, Search,CommandColumn,ExcelExport,PdfExport } from "@syncfusion/ej2-vue-grids";
import api from "@/services/http";
Vue.use(GridPlugin);

export default {
  data() {
    return {
      mobile:null,
      valid:null,
      passbaru:null,
      textAktif:true,
      umenu:[],
      verifpassbaru:null,
      loading:true,
      Kode:null,
      DialogPilihExport:false,
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
      akun:[],
      usermenu:null,
      AlertDataTerhapus:false,
      AlertBerhasilTerubah:false,
      user:[],
      token:null,
      DialogTambahUser: false,
      form: new FormData,
      editedIndex: -1,

      defaultItem: {
        Kode: "",
        Nama: "",
        password: "",
        UserMenu: "",
      },
      editedItem: {
        Kode: "",
        Nama: "",
        password: "",
        UserMenu: "",
      },
      toolbarOptions: ['Search'],
      DataUser: [],
      pageSettings: { pageSize: 5 },
    };
  },
  

  provide: {
    grid: [Page, Sort, Group, Resize, Toolbar, CommandColumn, Search,ExcelExport,PdfExport ]
  },

 async mounted(){
    this.token = localStorage.getItem('token')
    this.user = JSON.parse(localStorage.getItem('user'))
    await Promise.all([this.saya()])
    this.getdata()
    this.editedItem.Tgl_Masuk = this.date
    this.editedItem.Tgl_Lahir = this.date
    this.editedItem.Tgl_Phk = this.date
  },

  computed: {
    formTitleUser() {
      return this.editedIndex === -1 ? 'Tambah User Baru' : 'Ubah Data User'
    },
    Status () {
      return this.editedIndex === -1 ? 'Baru' : 'Ubah'
    },
  },
  
  watch: {
  
      // let a = this.DataUser.filter( function(item){return (item.UserMenu == newval.toUpperCase());} )
      // this.umenu = a
    windowSize(){
      if (this.windowSize.x < 450) {
        this.titleClass = "d-none"
        this.mobile = true
      }else{
        this.titleClass = "mr-4"
        this.mobile = false
      }
    },

    DialogTambahUser (val) {
      val || this.KeluarDialogUser()
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
    cariKode(Kode){
      if (Kode != null) {
          this.textAktif = false
        }else{
          this.textAktif = true
        }
      if (Kode == null || Kode == '' || Kode.length == 0) {
        this.editedIndex = -1
          this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      }else{
      this.Kode = Kode.toUpperCase()
      let a = this.DataUser.filter( function(item){return (item.Kode == Kode.toUpperCase());} );
      if (a.length > 0) {
          this.editedIndex = 1;
          this.textAktif = false
          this.editedItem.Nama = a[0].Nama
          this.editedItem.UserMenu = a[0].UserMenu
        }else{
          //do nothing
        }
      }
    },
  async saya(){
      await api.get('/menu',{ headers: {"Authorization" : `Bearer ${this.token}`} }).then(
        res=>{
          if (res) {
            this.akun = res.data
            console.log('menu',this.akun)
            //do noting
          }
        }).catch(err=>{
          // alert(err)
          if (err == "Error: Request failed with status code 401" && this.$route.path != "/login") {
            this.logout()
          }
        })
         if (this.akun.length == 0) {
            //do nothing
          }else{
            let route = this.$route.name
            let a = this.akun.filter( function(item){return (item.Nama == route);} );
            if (a.length > 0) {
               this.valid = true
            }else{
              this.valid = false
              this.loading = false
            }
            console.log(a)
          }
      },
      // cekmenu(){
        
      // },

    Simpan(){
      if(this.formTitleUser === "Tambah User Baru"){
        let Usermenu =  this.editedItem.UserMenu.UserMenu
        let menu = [{"Nama":"Beranda","Object":"Link","Visible":1,"Icon":"mdi-home"},{"Nama":"Master","Object":"List","Visible":1,"Icon":"mdi-database"},{"Nama":"Setting","Object":"List","Visible":1,"Icon":"mdi-cog"}]
        if (Usermenu == null || Usermenu == '') {Usermenu = this.editedItem.UserMenu}
          api.post('/register',{
            Kode: this.Kode,
            Nama: this.editedItem.Nama,
            UserMenu: Usermenu,
            password: this.editedItem.password,
            Menu:menu
            })
            .then((res)=>{
              if (res) {
                this.getdata()
              } else {
                //
              }
            })
      }else if(this.formTitleUser === "Ubah Data User"){
         //do nothing
      }
      this.KeluarDialogUser()    
    },

    commandClick: function(args) {
      if (args.target.classList.contains("custombutton")){
        // let data = JSON.stringify(args.rowData);
		
        console.log(args.rowData);
      } else if (args.target.classList.contains("Delete")){
        var r = confirm("Yakin Hapus Data?");
        if (r == true) { 
          api
            .delete("/user/"+args.rowData.Kode+'?token='+this.token)
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
        this.textAktif = false
        let data = args
            this.editedIndex = 1;
            console.log(data)
            this.editedItem = data.rowData
            this.DialogTambahUser = true

          if (args.rowData.Aktif == 0) {
            this.dataTemp = args.rowData
            this.dialogAktifData = true
            }else{
                let data = args;
                this.editedIndex = 1;
                this.Kode = data.rowData.Kode
                this.editedItem.Nama = data.rowData.Nama
                this.editedItem.Password = data.rowData.Password
                this.editedItem.UserMenu = data.rowData.UserMenu
                // this.dialogWO = true;
            }
      }
    },

    PdfExport(){
      let data = document.getElementById('karyawanview').ej2_instances[0];
      // console.log(data)
      data.pdfExportProperties = {
        pageOrientation: 'Landscape',
        fileName:"ReportKaryawan.pdf"
      }
      data.columns[1].visible = false
      data.columns[4].visible = false
      data.columns[3].visible = false
      // let pdfExportProperties = {
       
      // };
      // this.$refs.gridkaryawan.columns[0].visible = false;
      // this.$refs.gridkaryawan.columns[1].visible = true;
      this.$refs.gridkaryawan.pdfExport(data.pdfExportProperties);
    },
    excelExport(){
      this.$refs.gridkaryawan.excelExport();
      console.log(this.$refs.gridkaryawan)
      // let data = document.getElementById('karyawanview').ej2_instances[0];
      // console.log(data)
      // data.excelExport();
    },

    KeluarDialogUser () {
      this.DialogTambahUser = false
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem)
        this.editedIndex = -1
        this.Kode = null
        this.textAktif = true
      })
    },

    // beforeExport: function(args) {
      
    // },

    getdata(){
      api.get('/userdata',{ headers: {"Authorization" : `Bearer ${this.token}`} }).then(
				res => {
					console.log(res);
          this.DataUser = res.data
          this.loading = false
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
    logout(){
        api.post('/logout', this.token)
        .then(res=>{
          console.log(res)
        })
        localStorage.removeItem('token')
        localStorage.removeItem('user')
        location.reload(false)
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