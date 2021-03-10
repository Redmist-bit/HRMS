<template>
  <v-layout justify-center>
    <div class="home">

      <!-- Dashboard HRM -->
      <div class="col-12">
        <v-row dense>

          <!-- Absensi -->
          <v-col>
            <a>
              <v-hover
                v-slot="{ hover }"
              >
                <v-card
                  :elevation="hover ? 16 : 0"
                  class="mx-auto"
                  max-width="344"
                  outlined
                >
                  <v-list-item three-line>
                    <v-list-item-content>
                      <v-list-item-title class="headline">
                        Absensi
                        <v-icon class="mt-n1">mdi-book-account</v-icon>
                      </v-list-item-title>
                      <v-list-item-subtitle class="mt-n6">Data-data Absensi Karyawan</v-list-item-subtitle>
                    </v-list-item-content>

                    <v-list-item-avatar
                      tile
                      size="80"
                      color="grey"
                    ></v-list-item-avatar>
                  </v-list-item>
                </v-card>
              </v-hover>
            </a>
          </v-col>

          <!-- Karyawan -->
          <v-col>
            <a>
              <v-hover
                v-slot="{ hover }"
              >
                <v-card
                  :elevation="hover ? 16 : 0"
                  class="mx-auto"
                  max-width="344"
                  outlined
                >
                  <v-list-item three-line>
                    <v-list-item-content>
                      <v-list-item-title class="headline">
                        Karyawan
                        <v-icon class="mt-n1">mdi-badge-account-horizontal</v-icon>
                      </v-list-item-title>
                      <v-list-item-subtitle class="mt-n6">Data-data Karyawan</v-list-item-subtitle>
                    </v-list-item-content>

                    <v-list-item-avatar
                      tile
                      size="80"
                      color="grey"
                    ></v-list-item-avatar>
                  </v-list-item>
                </v-card>
              </v-hover>
            </a>
          </v-col>

          <!-- Panggajian -->
          <v-col>
            <a>
              <v-hover
                v-slot="{ hover }"
              >
                <v-card
                  :elevation="hover ? 16 : 0"
                  class="mx-auto"
                  max-width="344"
                  outlined
                >
                  <v-list-item three-line>
                    <v-list-item-content>
                      <v-list-item-title class="headline">
                        Penggajian
                        <v-icon class="mt-n1">mdi-account-cash</v-icon>
                      </v-list-item-title>
                      <v-list-item-subtitle class="mt-n6">Data-data Penggajian Karyawan</v-list-item-subtitle>
                    </v-list-item-content>

                    <v-list-item-avatar
                      tile
                      size="80"
                      color="grey"
                    ></v-list-item-avatar>
                  </v-list-item>
                </v-card>
              </v-hover>
            </a>
          </v-col>
        
        </v-row>
      </div>
      <!-- <img alt="Vue logo" src="../assets/logo.png">
      <HelloWorld msg="Welcome to Your Vue.js App"/> -->
    </div>
  </v-layout>
</template>

<script>
// @ is an alias to /src
// import HelloWorld from '@/components/HelloWorld.vue'

export default {
  name: 'Home',
  components: {
    // HelloWorld
  }
}
</script>
