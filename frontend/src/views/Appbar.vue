<template>
  <div>
    <!-- Appbar -->
    <v-app-bar
      app
      flat
      color="red darken-4"
    >
      <!-- Button Drawer Menu -->
      <v-btn
        fab
        dark
        text
        small
        class="mr-2"
        @click.stop="drawerMenu = !drawerMenu"
      >
        <v-icon>{{ drawerMenu ? 'mdi-chevron-left' : 'mdi-menu' }}</v-icon>
      </v-btn>

      <a class="title white--text">HRM</a>

      <v-spacer></v-spacer>

      <!-- Pencarian -->
        <v-col
          cols="5"
          sm="8"
          md="6"
        >
          <v-text-field
            solo
            dark
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
              dark
              small
              v-bind="attrs"
              v-on="on"
              @click.stop="accountshow = !accountshow"
            >
              <v-icon>{{ accountshow ? 'mdi-account-circle' : 'mdi-account-circle-outline' }}</v-icon>
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
        <v-menu
          v-model="MenuShowNotif"
          :close-on-content-click="false"
          :nudge-width="200"
          offset-y
        >
          <template v-slot:activator="{ on, attrs }">
            <v-btn
              fab
              text
              dark
              small
              v-bind="attrs"
              v-on="on"
              @click="notifshow = !notifshow"
            >
              <v-icon>{{ notifshow ? 'mdi-bell' : 'mdi-bell-outline' }}</v-icon>
            </v-btn>
          </template>

          <v-card>
            <v-list>
              <v-list-item>
                
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
      v-model="drawerMenu"
      color="grey lighten-5"
    >
      <v-toolbar
        flat
        color="grey lighten-5"
      >
        <a>
          <v-list-item>
            <v-list-item-content
              class="mx-n4"
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

      <v-list dense>
        <v-list-item
          v-for="item in items"
          :key="item.title"
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
        <v-divider></v-divider>
      </v-list>
    </v-navigation-drawer>

    
  </div>
</template>

<script>
  export default {
    data () {
      return {
        accountshow: false,
        notifshow: false,
        MenuShowAkun: false,
        MenuShowNotif: false,
        drawerMenu: true,
        items: [
          { title: 'Dashboard', icon: 'mdi-view-dashboard', link: '/' },
          { title: 'Data Karyawan', icon: 'mdi-badge-account-horizontal', link: '/Karyawan' },
          { title: 'Absensi Karyawan', icon: 'mdi-book-account', link: '/Absensi' },
          { title: 'Gologan Karyawan', icon: 'mdi-account-hard-hat', link: '/Golongan' },
          { title: 'Penggajian', icon: 'mdi-account-cash', link: '/Penggajian' },
        ],
      }
    },
  }
</script>