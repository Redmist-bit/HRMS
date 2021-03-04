<template>
  <div>
    <!-- Appbar -->
    <v-app-bar
      app
      flat
      color="white"
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

      <a class="title black--text">HRM</a>

      <v-spacer></v-spacer>

      <!-- Pencarian -->
        <v-col
          cols="5"
          sm="8"
          md="6"
        >
          <v-text-field
            solo
            color="red darken-4"
            class="mt-7 rounded-lg"
            placeholder="Percarian"
            prepend-inner-icon="mdi-magnify"
          ></v-text-field>
        </v-col>
      <v-spacer></v-spacer>

      <!-- Button Akun -->
      <div class="text-center">
        <v-menu
          v-model="MenuShowAkun"
          :close-on-content-click="false"
          :nudge-width="200"
          offset-y
        >
          <template v-slot:activator="{ on, attrs }">
            <v-btn
              fab
              text
              
              small
              v-bind="attrs"
              v-on="on"
              @click.stop="accountshow = !accountshow"
            >
              <v-icon>mdi-account-circle-outline</v-icon>
              <!-- <v-icon>{{ accountshow ? 'mdi-account-circle' : 'mdi-account-circle-outline' }}</v-icon> -->
            </v-btn>
          </template>

          <v-card>
            <v-list>
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

              <!-- Logout -->
              <v-list-item>
                <v-btn
                  dark
                  block
                  depressed
                  color="red darken-4"
                  class="text-capitalize rounded-lg"
                >
                  Keluar
                  <v-icon class="ml-1">mdi-logout-variant</v-icon>
                </v-btn>
              </v-list-item>

              <!-- Register -->
              <v-list-item>
                <v-btn
                  dark
                  block
                  outlined
                  depressed
                  color="grey darken-3"
                  class="text-capitalize rounded-lg"
                >
                  <v-icon class="mr-1">mdi-account-plus-outline</v-icon>
                  Daftar Akun
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
    </v-app-bar>

    <!-- Navigation Drawer -->
    <v-navigation-drawer
      app
      fixed
      width="300"
      v-model="drawerMenu"
      color="white"
    >
      <v-toolbar
        flat
        color="white"
      >
        <a>
          <v-list-item>
            <v-list-item-content
              class="mx-n6"
            >
              <v-img
                to="/home"
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

      <!-- Menu -->
      <v-list nav dense>
        <v-list-item
          v-for="item in menu1"
          :key="item.title"
          :to="item.link"
          link
          color="red darken-4"
        >
          <v-list-item-icon>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-item-icon>

          <v-list-item-content>
            <v-list-item-title>{{ item.title }}</v-list-item-title>
          </v-list-item-content>
          </v-list-item>
          <v-divider></v-divider>

          <!-- Laporan -->
          <v-list-group
            v-for="item in Laporan"
            :key="item.title"
            v-model="item.active"
            :prepend-icon="item.action"
            no-action
            color="red darken-4"
          >
            <template v-slot:activator>
              <v-list-item-content>
                <v-list-item-title v-text="item.title"></v-list-item-title>
              </v-list-item-content>
            </template>

            <v-list-item
              v-for="child in item.ItemsLaporan"
              :key="child.title"
              :to="child.link"
              link
              color="red darken-4"
            >
              <v-list-item-content>
                <v-list-item-title v-text="child.title"></v-list-item-title>
              </v-list-item-content>
              <v-icon v-text="child.icon"></v-icon>
            </v-list-item>
          </v-list-group>
          <v-divider></v-divider>

          <!-- Setting -->
          <v-list-group
            v-for="item in Setting"
            :key="item.title"
            v-model="item.active"
            :prepend-icon="item.action"
            no-action
            color="red darken-4"
          >
            <template v-slot:activator>
              <v-list-item-content>
                <v-list-item-title v-text="item.title"></v-list-item-title>
              </v-list-item-content>
            </template>

            <v-list-item
              v-for="child in item.ItemsSetting"
              :key="child.title"
              :to="child.link"
              link
              color="red darken-4"
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
      color="white"
      v-model="drawerNotif"
    >
      <v-toolbar
        flat
        color="grey lighten-2"
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
        
        <v-layout justify-center>
          <v-toolbar-title class="title">
            Notifikasi
            <v-icon>mdi-bell-ring</v-icon>
          </v-toolbar-title>
        </v-layout>
      </v-toolbar>
      <v-divider></v-divider>
    </v-navigation-drawer>

    
  </div>
</template>

<script>
  export default {
    data () {
      return {
        drawerNotif: null,
        accountshow: false,
        notifshow: false,
        MenuShowAkun: false,
        MenuShowNotif: false,
        drawerMenu: true,

        menu1: [
          { title: 'Dashboard', icon: 'mdi-view-dashboard', link: '/' },
          { title: 'Data Karyawan', icon: 'mdi-badge-account-horizontal', link: '/Karyawan' },
          { title: 'Absensi Karyawan', icon: 'mdi-book-account', link: '/Absensi' },
          { title: 'Gologan Karyawan', icon: 'mdi-account-hard-hat', link: '/Golongan' },
          { title: 'Penggajian', icon: 'mdi-account-cash', link: '/Penggajian' },
        ],

        Setting: [
          {
            action: 'mdi-cog',
            ItemsSetting: [
              { title: 'Pengguna', icon: 'mdi-account-cog' , link: 'Pengguna' }
            ],
            title: 'Pengaturan',
          },
        ],

        Laporan: [
          {
            action: 'mdi-file',
            ItemsLaporan: [
              { title: 'Laporan Data Karyawan', link: 'LapDataKaryawan' },
              { title: 'Laporan Absensi karyawan', link: 'LapAbsensiKaryawan' }
            ],
            title: 'Laporan',
          },
        ],
      }
    },
  }
</script>