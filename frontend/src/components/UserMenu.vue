<template>
  <div>
    <v-toolbar>
      <v-col cols="6" md="3">
        <v-autocomplete
          dense
          color="dark"
          label="Jabatan"
        >
        </v-autocomplete>
      </v-col>

      <div>
        <v-btn
          dark
          color="red darken-4 mx-4"
          class="text-capitalize"
          
        >
          Tampilkan Menu
        </v-btn>
      </div>
      
      <div>
        <v-btn
          dark
          color="red darken-4 mx-4"
          class="text-capitalize"
          
        >
          Simpan
        </v-btn>
      </div>

      <v-spacer></v-spacer>
      <v-dialog
        v-model="DialogUserMenu"
        max-width="500px"
        scrollable
        persistent
      >
        <template v-slot:activator="{ on, attrs }">
          <v-btn
            class="text-capitalize mx-n2"
            color="dark"
            v-bind="attrs"
            v-on="on"
            depressed 
          >
            <v-icon class="mr-1">mdi-plus</v-icon>
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
              color="dark"
              class="text-capitalize"
              @click="Reset"
            >
              <v-icon class="mr-1">mdi-refresh</v-icon>
            </v-btn>
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
                <v-col cols="12" sm="6" md="6">
                  <v-text-field
                    dense
                    clearable
                    label="No"
                    color="dark"
                    v-model="editedItem.no"
                  ></v-text-field>
                </v-col>

                <v-col cols="12" sm="6" md="6">
                  <v-text-field
                    dense
                    clearable
                    label="Kode Menu"
                    color="dark"
                    v-model="editedItem.KodeMenu"
                  ></v-text-field>
                </v-col>

                <v-col cols="12" sm="6" md="6">
                  <v-text-field
                    dense
                    clearable
                    label="Parent"
                    color="dark"
                    v-model="editedItem.Parent"
                  ></v-text-field>
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
                  <v-text-field
                    dense
                    clearable
                    label="Object"
                    color="dark"
                    v-model="editedItem.Object"
                  ></v-text-field>
                </v-col>

                <v-col cols="12" sm="6" md="6">
                  <v-text-field
                    dense
                    clearable
                    label="User Menu"
                    color="dark"
                    v-model="editedItem.UserMenu"
                  ></v-text-field>
                </v-col>

                <v-col cols="12" sm="6" md="6">
                  <v-text-field
                    dense
                    clearable
                    label="Visible"
                    color="grey darken-2"
                    v-model="editedItem.Visible"
                  ></v-text-field>
                </v-col>

                <v-col cols="12" sm="6" md="6">
                  <v-text-field
                    dense
                    clearable
                    label="Icon"
                    color="grey darken-2"
                    v-model="editedItem.Icon"
                  ></v-text-field>
                </v-col>
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
              <v-icon class="mr-1">mdi-refresh</v-icon>
              Refresh
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
    
    <!-- Card User Menu Depan -->
    <v-col>
      <v-card
        class="mx-auto"
        max-width="300"
        tile
      >
        <v-list flat dense nav>
          <v-list-item-group
            color="primary"
          >
            <v-list-item
              v-for="(item, i) in Beranda"
              :key="i"
            >
              <template v-slot:default="{ active }">
                <v-list-item-action>
                  <v-checkbox :input-value="active"></v-checkbox>
                </v-list-item-action>

                <v-list-item-content>
                  <v-list-item-title v-text="item.text"></v-list-item-title>
                </v-list-item-content>
              </template>
            </v-list-item>
          </v-list-item-group>

          <v-list-group
            v-for="item in Master"
            :key="item.title"
            
            no-action
          >
            <template v-slot:activator>
              <v-list-item-action>
                <v-checkbox></v-checkbox>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title v-text="item.title"></v-list-item-title>
              </v-list-item-content>
            </template>

            <v-list-item
              v-for="child in item.items"
              :key="child.title"
              link
            >
              <template v-slot:default="{ active }">
                <v-list-item-action>
                  <v-checkbox :input-value="active"></v-checkbox>
                </v-list-item-action>

                <v-list-item-content>
                  <v-list-item-title v-text="child.title"></v-list-item-title>
                </v-list-item-content>
              </template>
            </v-list-item>
          </v-list-group>
        </v-list>
      </v-card>
    </v-col>
  </div>
</template>

<script>
  export default {
    data: () => ({
      DialogUserMenu: false,
      editedIndex: -1,
      defaultItem: {
        no: "",
        KodeMenu: "",
        Parent: "",
        Nama: "",
        Object: "",
        UserMenu: "",
        Visible: "",
        Icon: ""
        
      },
      editedItem: {
        no: "",
        KodeMenu: "",
        Parent: "",
        Nama: "",
        Object: "",
        UserMenu: "",
        Visible: "",
        Icon: ""
        
      },
      Beranda: [
        { text: 'Beranda', icon: 'mdi-home' },
      ],

      Master: [
        {
          action: 'mdi-database',
          items: [
            { title: 'Karyawan' },
            { title: 'UserMenu' }

          ],
          title: 'Master',
        },
      ],
    }),

    mounted(){

    },

    computed: {
      formTitleUserMenu () {
        return this.editedIndex === -1 ? 'Tambah User Menu' : 'Ubah User Menu'
      },
    },

    watch: {
      DialogUserMenu(val) {
        val || this.KeluarDialogUserMenu();
      },
    },

    DialogUserMenu (val) {
      val || this.KeluarDialogUserMenu()
    },

    methods: {
      Simpan(){
        if(this.formTitleUserMenu === "Tambah User Menu"){
          // this.TambahData()
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