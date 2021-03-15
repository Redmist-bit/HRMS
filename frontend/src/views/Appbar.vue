<template>
  <div>
    <!-- Appbar -->
    <v-app-bar
      app
      flat
    >
      <!-- Button Drawer Menu -->
      <v-btn
        fab
        text
        small
        class="mr-2"
        @click.stop="drawerMenu = !drawerMenu"
      >
        <v-icon>{{ drawerMenu ? 'mdi-backburger' : 'mdi-menu' }}</v-icon>
      </v-btn>

      <a @click="home">
        <v-list-item>
          <v-toolbar-title class="title">HRM</v-toolbar-title>
        </v-list-item>
      </a>

      <v-spacer></v-spacer>

      <!-- <v-switch
        v-model="$vuetify.theme.dark"
        hide-details
        color="red darken-4"
        label="Mode Malam"
      ></v-switch> -->

      <!-- <div>
        <ModeMalam/>
      </div> -->

      <!-- Pencarian -->
      <!-- <v-col
        cols="5"
        sm="8"
        md="4"
      >
        <v-text-field
          solo
          flat
          dense
          outlined
          clearable
          color="grey darken-1"
          class="mt-7 rounded-lg mr-1"
          placeholder="Pencarian"
          
        >
          <template v-slot:append>
            <v-btn
              text
              dark
              small
              depressed
              width="50"
              height="40"
              color="red darken-4"
              class="rounded-r-lg mx-n3"
            >
              <v-icon>mdi-magnify</v-icon>
            </v-btn>
          </template>

          <v-divider></v-divider>
        </v-text-field>
      </v-col> -->

      <v-divider inset vertical class="mr-1"></v-divider>

      <!-- Button Akun -->
      <div class="text-center">
        <v-menu
          v-model="MenuShowAkun"
          :close-on-content-click="false"
          :nudge-width="150"
          offset-y
        >
          <template v-slot:activator="{ on, attrs }">
            <v-btn
              fab
              text
              
              small
              v-bind="attrs"
              v-on="on"
            >
              <v-icon>mdi-account-circle-outline</v-icon>
              <!-- <v-icon>{{ accountshow ? 'mdi-account-circle' : 'mdi-account-circle-outline' }}</v-icon> -->
            </v-btn>
          </template>

          <v-card outlined class="rounded-lg">
            <v-list class="rounded-lg" v-show="this.token == null">
              <!-- Login -->
              <v-list-item>
                <v-btn
                  block
                  outlined
                  depressed
                  to="/Login"
                  color="red darken-4"
                  class="text-capitalize rounded-lg"
                >
                  <v-icon class="mr-1">mdi-login-variant</v-icon>
                  Masuk
                </v-btn>
              </v-list-item>

              <!-- Register -->
              <v-list-item>
                <v-btn
                  block
                  outlined
                  depressed
                  to="/Register"
                  color="dark"
                  class="text-capitalize rounded-lg"
                >
                  <v-icon class="mr-1">mdi-account-plus-outline</v-icon>
                  Daftar Akun
                </v-btn>
              </v-list-item>
            </v-list>
            <v-list class="rounded-lg" v-show="this.token !=null">
              <!-- Logout -->
              <v-list-item>
                <v-btn
                  dark
                  block
                  depressed
                  color="red darken-4"
                  class="text-capitalize rounded-lg"
                  @click="logout"
                >
                  Keluar
                  <v-icon class="ml-1">mdi-logout-variant</v-icon>
                </v-btn>
                
              </v-list-item>
            </v-list>
          </v-card>
        </v-menu>
      </div>

      <!-- Button Tampilkan Notifikasi -->
      <div class="text-center">       
        <v-btn
          fab
          text
          small
          @click.stop="drawerNotif = !drawerNotif"
        >
          <!-- <v-icon>{{ notifshow ? 'mdi-bell' : 'mdi-bell-outline' }}</v-icon> -->
          <v-icon>mdi-bell-outline</v-icon>
        </v-btn>
      </div>

      <!-- Button Tampilkan Setting -->
      <div class="text-center">
        <v-menu
          v-model="MenuShowSetting"
          :close-on-content-click="false"
          :nudge-width="150"
          offset-y
        >
          <template v-slot:activator="{ on, attrs }">
            <v-btn
              fab
              text
              
              small
              v-bind="attrs"
              v-on="on"
            >
              <v-icon>mdi-cog</v-icon>
            </v-btn>
          </template>

          <v-card outlined height="70" class="rounded-lg">
            <v-list>
              <v-list-item>
                <v-layout justify-center class="mt-n3">
                <ModeMalam/>
                </v-layout>
              </v-list-item>

            </v-list>
          </v-card>
        </v-menu>
      </div>
    </v-app-bar>

    <!-- Navigation Drawer -->
    <v-navigation-drawer
      app
      fixed
      width="250"
      v-model="drawerMenu"
    >
      <v-toolbar
        flat
      >
        <a @click="home">
          <v-list-item>
            <v-list-item-content
              class="mx-n6"
            >
              <v-img
                max-width="38"
                max-height="150px"
                src="../assets/LogoTrinity.png"
              ></v-img>
            </v-list-item-content>

            <div class="mx-8">
              <v-toolbar-title class="title">Trinity Auto</v-toolbar-title>
            </div>
          </v-list-item>
        </a>
      </v-toolbar>
      
      <v-divider></v-divider>

      <!-- Menu Beranda -->
      <v-list nav dense>
        <v-list-item
          v-for="(item,key) in Beranda"
          :key="key"
          :to="item.link"
          link
        >
          <v-list-item-icon>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-item-icon>

          <v-list-item-content>
            <v-list-item-title>{{ item.title }}</v-list-item-title>
          </v-list-item-content>
          </v-list-item>

          <!-- Master -->
          <v-list-group
            v-for="item in Menu"
            :key="item.title"
            v-model="item.active"
            :prepend-icon="item.action"
            no-action
            color="dark"
          >
            <template v-slot:activator>
              <v-list-item-content>
                <v-list-item-title v-text="item.title"></v-list-item-title>
              </v-list-item-content>
            </template>

            <v-list-item
              v-for="child in item.ListMenu"
              :key="child.title"
              :to="child.link"
              link
              color="dark"
            >
              <v-list-item-content>
                <v-list-item-title v-text="child.title"></v-list-item-title>
              </v-list-item-content>
              <v-icon v-text="child.icon"></v-icon>
            </v-list-item>
          </v-list-group>
      </v-list>
    </v-navigation-drawer>

    <!-- Notif Drawer -->
    <v-navigation-drawer
      app
      fixed
      right
      temporary
      width="350"
      color="dark"
      v-model="drawerNotif"
    >
      <v-toolbar
        flat
        color="dark"
      >
        <div>
          <v-btn
            fab
            text
            small
            @click.stop="drawerNotif = !drawerNotif"
          >
            <v-icon>mdi-close</v-icon>
          </v-btn>
        </div>
        
        <span class="title mx-3">
          Notifikasi
          <v-icon>mdi-bell-ring</v-icon>
        </span>
      </v-toolbar>
      <v-divider></v-divider>
    </v-navigation-drawer>

    
  </div>
</template>

<script>
import api from "@/services/http";
  import ModeMalam from '@/views/ModeMalam';
  export default {
    components: {
      ModeMalam,
    },

    data: () => {
      return {
        drawerNotif: null,
        accountshow: false,
        notifshow: false,
        MenuShowAkun: false,
        MenuShowNotif: false,
        MenuShowSetting: false,
        drawerMenu: true,
        token:null,
        user:[],

        // Menu Navigation Drawer

        // Beranda
        Beranda: [
          // { title: 'Beranda', icon: 'mdi-home', link: '/' },
          
        ],

        // Menu
        Menu: [
          // Master
          // {
          //   action: 'mdi-database',
          //   ListMenu: [
          //     { title: 'Karyawan', icon: 'mdi-badge-account-horizontal' , link: 'Karyawan' }
          //   ],
          //   title: 'Master',
          // },

          // // Proses
          // {
          //   action: 'mdi-database',
          //   ListMenu: [
              
          //   ],
          //   title: 'Proses',
          // },
        ],
      }
    },

    mounted(){
      this.token = localStorage.getItem('token')
      this.menu()
      this.user = JSON.parse(localStorage.getItem('user'))
    },

    computed: {

    },
    watch: {

    },

    methods: {
      home(){
        if (this.$router.currentRoute.name == "Home") {
          //do nothing
        }else{
          this.$router.push("/")
        }
      },
      menu(){
      // console.log()
      if (this.token == null) {
        //do nothing
        this.$router.replace("/login")
      }else{
        api.get('/menu?token='+this.token).then(
        res=>{
          // console.log('res',res)
          let tes = []
          for (let index = 0; index < res.data.length; index++) {
            const element = res.data[index];
            element.title = res.data[index].Nama;
            element.action = res.data[index].Icon;
            element.icon = res.data[index].action
            element.link = res.data[index].Nama

            tes.push(element)
          }
          // console.log('tes',tes)
          var id = tes.filter( function(item){return (item.Parent == null && item.Object == "List");} );
          console.log('id',id)
          let List = []
          for (let index = 0; index < id.length; index++) {
            const element = id[index];
            element.ListMenu = tes.filter( function(item){return (item.Parent == id[index].KodeMenu);} );
            List.push(element)
          }
          // console.log(List)
          var home = tes.filter( function(item){return (item.Object == "Home");} );
          let beranda = []
          for (let index = 0; index < home.length; index++) {
            const element = home[index];
            element.title = home[index].Nama
            element.icon = home[index].Icon
            element.link = "/"
            beranda.push(element)
          }
          // // console.log('akwowk',List)
          // // this.List = List
          this.Beranda = beranda
          this.Menu = List
          // console.log(List)
          // this.isLoading = false
          // console.log('listmenu',this.List)
          }
        )
        .catch(err=>{
          // alert(err)
          if (err == "Error: Request failed with status code 401" && this.$route.path != "/login") {
            this.logout()
          }
        })
       }
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
    },
  }
</script>