<template>
  <div class="pa-3">
    <!-- Card User Menu Depan -->
    <div>
      <v-card
        outlined
        class="mx-auto rounded-lg elevation-15"
        max-width="470"
      >
        <v-toolbar flat dense color="dark">
          <span class="font-weight-bold">Pilih Jabatan</span>
        </v-toolbar>
        <v-divider></v-divider>
        
        <div class="pa-3">
          <div>
            <v-autocomplete
              solo
              flat
              dense
              outlined
              color="red darken-4"
              class="rounded-lg font-weight-bold"
              v-model="JabatanSelect"
              :items="Jabatan"
              label="Pilih Jabatan--"
            >
            </v-autocomplete>
          </div>

          <div class="mt-n3">
            <v-btn
              dark
              block
              depressed
              color="red darken-4"
              class="text-capitalize rounded-lg"
              @click="tampilkanMenu"
            >
              Tampilkan Menu
              <v-icon class="ml-1">mdi-format-list-checkbox</v-icon>
            </v-btn>
          </div>
        </div>
      </v-card>
    </div>

    <div class="mt-3">
      <v-card
        outlined
        class="mx-auto rounded-lg elevation-15"
        max-width="470"
      >
        <v-toolbar flat dense color="dark">
          <span class="font-weight-bold">User Menu</span>
          <v-spacer></v-spacer>

          <v-dialog
            v-model="DialogUserMenu"
            max-width="500px"
            scrollable
            persistent
          >
            <template v-slot:activator="{ on, attrs }">
              <v-btn
                text
                class="text-capitalize mx-n3 rounded-lg"
                color="dark"
                v-bind="attrs"
                v-on="on"
                v-show="JabatanSelect"
              >
                <v-icon class="mr-1">mdi-plus-thick</v-icon>
                Tambah
              </v-btn>
            </template>
            <v-card>
              <v-toolbar
                flat
              >
                <v-toolbar-title>
                  <span class="headline">{{ formTitleUserMenu }}</span>
                </v-toolbar-title>
                <v-spacer></v-spacer>
                <v-btn
                  fab
                  text
                  small
                  @click="KeluarDialogUserMenu"
                >
                  <v-icon>mdi-window-close</v-icon>
                </v-btn>
              </v-toolbar>
              <v-divider></v-divider>
              
              <v-card-text>
                <v-container class="mt-4">
                  <v-row>             

                    <!-- <v-col cols="12" sm="6" md="6">
                      <v-text-field
                        dense
                        clearable
                        label="Kode Menu"
                        color="dark"
                        v-model="editedItem.KodeMenu"
                      ></v-text-field>
                    </v-col> -->

                    <v-col cols="12" sm="6" md="6">
                      <v-select
                        dense
                        clearable
                        label="Parent"
                        color="dark"
                        :items="ParentTemp"
                        item-text="Nama"
                        item-value="KodeMenu"
                        v-model="ParentSelect"
                        return-object
                      ></v-select>
                    </v-col>

                    <v-col cols="12" sm="6" md="6">
                      <v-text-field
                        dense
                        clearable
                        label="Nama"
                        color="dark"
                        v-model="editedItem.Nama"
                      ></v-text-field>
                    </v-col>

                    <v-col cols="12" sm="6" md="6">
                      <v-select
                      v-show="ParentSelect != null"
                        dense
                        clearable
                        label="Object"
                        color="dark"
                        :items="ObjectTemp"
                        item-text="Object"
                        item-value="Object"
                        v-model="editedItem.Object"
                        return-object
                      ></v-select>
                      <v-select
                      v-show="ParentSelect == null || ParentSelect.length == 0"
                        dense
                        clearable
                        label="Object"
                        color="dark"
                        :items="ObjectTemp"
                        item-text="Object"
                        item-value="Object"
                        v-model="editedItem.Object"
                        return-object
                      ></v-select>
                    </v-col>

                    <!-- <v-col cols="12" sm="6" md="6">
                      <v-text-field
                        dense
                        clearable
                        label="User Menu"
                        color="dark"
                        v-model="editedItem.UserMenu"
                      ></v-text-field>
                    </v-col> -->

                    <v-col cols="12" sm="6" md="6">
                      <v-text-field
                        dense
                        clearable
                        label="Icon"
                        color="dark"
                        v-model="editedItem.Icon"
                      ></v-text-field>
                    </v-col>

                    <v-col cols="12" sm="6" md="6">
                      <!-- <v-text-field
                        dense
                        clearable
                        label="Visible"
                        color="grey darken-2"
                        v-model="editedItem.Visible"
                      ></v-text-field> -->

                      <v-switch
                        dense
                        class="mt-n2"
                        v-model="editedItem.Visible"
                        color="red darken-4"
                        label="Visible"
                      ></v-switch>
                    </v-col>
                  </v-row>
                </v-container>
              </v-card-text>
              <v-divider></v-divider>
              <v-card-actions>
              <v-spacer></v-spacer>
                <v-btn
                  fab
                  text
                  small
                  color="dark"
                  class="text-capitalize mx-3"
                  @click="Reset"
                >
                  <v-icon>mdi-refresh</v-icon>
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
        <v-divider></v-divider>
        <v-list flat dense>
          <v-list-item-group
            color="dark"
          >
            <v-list-item
              v-for="(item, i) in Beranda"
              :key="i"
            >
              <template v-slot:default="{ active }">
                <v-list-item-action>
                  <v-checkbox color="red lighten-1" v-on:change="toggleBeranda(item)" v-bind:checked="item.enabled" :input-value="active" v-model="item.enabled"></v-checkbox>
                </v-list-item-action>

                <v-list-item-content>
                  <v-list-item-title v-text="item.Nama"></v-list-item-title>
                </v-list-item-content>

                <!-- Btn Delete -->
                <div class="mx-n2">
                  <v-btn fab text small @click="hpsBeranda(item)">
                    <v-icon color="red lighten-1">mdi-delete-outline</v-icon>
                  </v-btn>
                </div>
              </template>
            </v-list-item>
          </v-list-item-group>

          <v-list-group
            v-for="item in Master"
            :key="item.Nama"
            color="dark"
            no-action
          >
            <template v-slot:activator>
              <v-list-item-action>
                <v-checkbox color="red lighten-1" v-on:change="toggleGrup(item)" v-bind:checked="item.enabled" v-model="item.enabled"></v-checkbox>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title v-text="item.Nama"></v-list-item-title>
              </v-list-item-content>

              <!-- Btn Delete -->
              <div class="mx-n9">
                <v-btn fab text small @click="hpsGrup(item)">
                  <v-icon color="red lighten-1">mdi-delete-outline</v-icon>
                </v-btn>
              </div>
            </template>

            <v-list-item
              v-for="(child,i) in item.items"
              :key="child.Nama"
              link
            >
              <template v-slot:default="{ active }">
                <v-list-item-action>
                  <v-checkbox color="red lighten-1" v-on:change="toggleChild(child,i)" v-bind:checked="child.enabled" v-model="child.enabled" :input-value="active"></v-checkbox>
                </v-list-item-action>

                <v-list-item-content>
                  <v-list-item-title v-text="child.Nama"></v-list-item-title>
                </v-list-item-content>
                
                <!-- Btn Delete -->
                <div class="mx-n2">
                  <v-btn fab text small @click="hpsChild(child)">
                    <v-icon color="red lighten-1">mdi-delete-outline</v-icon>
                  </v-btn>
                </div>
              </template>
            </v-list-item>
          </v-list-group>
        </v-list>
      </v-card>
    </div>

  </div>
  
</template>

<script>
import api from "@/services/http";
  export default {
    data: () => ({
      DialogUserMenu: false,
      editedIndex: -1,
      token:null,
      MenuTemp:[],
      ParentTemp:[],
      ObjectTemp:[],
      ParentSelect:null,
      JabatanSelect:null,
      resMenu:[],
      defaultItem: {
        KodeMenu: "",
        Nama: "",
        Object: "",
        UserMenu: "",
        Visible: "",
        Icon: ""
        
      },
      editedItem: {
        KodeMenu: "",
        Nama: "",
        Object: "",
        UserMenu: "",
        Visible: "",
        Icon: ""
        
      },
      Jabatan:[],
      Beranda: [
        // { Nama: 'Beranda'},
      ],

      Master: [
        // {
        //   items: [
        //     { Nama: 'Karyawan' },
        //     { Nama: 'UserMenu' }

        //   ],
        //   Nama: 'Master',
        // },
      ],
    }),

    mounted(){
      this.token = localStorage.getItem('token')
      this.getJabatan()
    },

    computed: {
      formTitleUserMenu () {
        return this.editedIndex === -1 ? 'Tambah User Menu' : 'Ubah User Menu'
      },
    },

    watch: {
      DialogUserMenu(val) {
        val || this.KeluarDialogUserMenu();
        if (this.DialogUserMenu == true) {
          this.ObjectTemp = ['List','Link']
          api.get('menuselected/'+this.JabatanSelect+'?token='+this.token).then(res=>{
            this.MenuTemp = res.data
            var parent = res.data.Menu.filter( function(item){return (item.Parent == null && item.Object != "Link");} );
            this.ParentTemp = parent
          })
        }
      },
      ParentSelect(){
        if (this.ParentSelect == null || this.ParentSelect.length == 0) {
          //do nothing
          this.ObjectTemp = [...new Array]
          this.ObjectTemp = ['List','Link']
        }else if(this.ParentSelect.Object == "List") {
          this.ObjectTemp = ['Page']
        }else{
          //do nothing
        }
      }
    },

    DialogUserMenu (val) {
      val || this.KeluarDialogUserMenu()
    },

    methods: {
      tampilkanMenu(){
        api.get('/menuselected/'+this.JabatanSelect+'?token='+this.token).then(
				res => {
          console.log(res.data)
          let tes = []
          for (let index = 0; index < res.data.Menu.length; index++) {
            const element = res.data.Menu[index];
            element.enabled = !!parseInt(res.data.Menu[index].Visible);
            tes.push(element)
          }
          // console.log('tes',tes)
          var id = tes.filter( function(item){return (item.Parent == null && item.Object == "List");} );
          console.log('id',id)
          let List = []
          for (let index = 0; index < id.length; index++) {
            const element = id[index];
            element.items = tes.filter( function(item){return (item.Parent == id[index].KodeMenu);} );
            List.push(element)
          }
          // console.log(List)
          var home = tes.filter( function(item){return (item.Object == "Link" && item.Nama == "Beranda");} );
          let beranda = []
          for (let index = 0; index < home.length; index++) {
            const element = home[index];
            beranda.push(element)
          }
          // // console.log('akwowk',List)
          // // this.List = List
          this.Beranda = beranda
          this.Master = List
          this.resMenu = res.data
				},
				err => {
					console.log(err);
				}
			)
      },
      toggleBeranda(item){
        item.enabled = !!item.enabled
        item.Visible = item.enabled*1
        api.put("/updatemenu/" +item.KodeMenu+'?token='+this.token,{
            Visible: item.Visible,
					})
					.then((res) => {
						if (!res) {
							//do nothing
						}else{
              // this.getdata()
						}
						
					})
        console.log(this.Beranda)
      },
      toggleGrup(item){
        item.enabled = !!item.enabled
        item.Visible = item.enabled*1
        api.put("/updatemenu/" +item.KodeMenu+'?token='+this.token,{
            Visible: item.Visible,
					})
					.then((res) => {
						if (!res) {
							//do nothing
						}else{
              // this.getdata()
						}
						
					})
      },
      toggleChild(child){
        child.enabled = !!child.enabled
        child.Visible = child.enabled*1
        api.put("/updatemenu/" +child.KodeMenu+'?token='+this.token,{
            Visible: child.Visible,
					})
					.then((res) => {
						if (!res) {
							//do nothing
						}else{
              // this.getdata()
						}
						
					})
      },
      hpsBeranda(item){
       var r = confirm("Yakin Hapus Menu "+item.Nama+" ?");
        if (r == true) { 
          api
            .delete("/menu/"+item.KodeMenu+'?token='+this.token)
            .then((res) =>{
              if (res) {
                this.tampilkanMenu()
              }else{
                //do nothing
              }
              
            })
            .catch((err) => {
              console.log(err);
            });
        }
      },
      hpsGrup(item){
       var r = confirm("Yakin Hapus Menu "+item.Nama+" ?");
        if (r == true) { 
          api
            .delete("/menu/"+item.KodeMenu+'?token='+this.token)
            .then((res) =>{
              if (res) {
                this.tampilkanMenu()
              }else{
                //do nothing
              }
              
            })
            .catch((err) => {
              console.log(err);
            });
        }
      },
      hpsChild(child){
       var r = confirm("Yakin Hapus Menu "+child.Nama+" ?");
        if (r == true) { 
          api
            .delete("/menu/"+child.KodeMenu+'?token='+this.token)
            .then((res) =>{
              if (res) {
                this.tampilkanMenu()
              }else{
                //do nothing
              }
              
            })
            .catch((err) => {
              console.log(err);
            });
        }
      },
      getJabatan(){
        api.get('/list?token='+this.token).then(
				res => {
          console.log(res.data)
          this.Jabatan = res.data
				},
				err => {
					console.log(err);
				}
			)
      },
      Simpan(){
        if(this.formTitleUserMenu === "Tambah User Menu"){
          let parent
          if (this.ParentSelect == null) {
            parent = null
          }else{
            parent = this.ParentSelect.KodeMenu
          }
          api.post('/addmenu?token='+this.token,{
            Parent: parent,
            Nama: this.editedItem.Nama,
            Object: this.editedItem.Object,
            UserMenu: this.JabatanSelect,
            Visible: this.editedItem.Visible,
            Icon: this.editedItem.Icon
            })
            .then((res)=>{
              if (res) {
                this.tampilkanMenu()
              } else {
                //
              }
            })
        }
        else{
          // this.UpdateData()
        }
        this.KeluarDialogUserMenu()
      },

      KeluarDialogUserMenu () {
        this.DialogUserMenu = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.ParentSelect = null
          this.editedIndex = -1
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