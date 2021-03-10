<template>
  <v-container>
    <v-layout justify-center>
      <v-card
        outlined
        width="350"
        class="elevation-15 rounded-lg mt-12"
      >
        <v-layout justify-center>
          <v-card-title class="title">
            Masuk
          </v-card-title>
        </v-layout>

        <v-card-text class="mt-n6">
          <v-col
            cols="12"
            sm="12"
            md="12"
          >
            <v-subheader class="mx-n4 body-1">Username</v-subheader>
            <v-text-field
              dense
              outlined
              color="red darken-4"
              class="form-control rounded-lg mt-n2"
              v-model="credentials.name"
            ></v-text-field>
          </v-col>

          <v-col
            cols="12"
            sm="12"
            md="12"
          >
            <v-subheader class="mx-n4 mt-n10 body-1">Password</v-subheader>
            <v-text-field
              dense
              outlined
              color="red darken-4"
              class="form-control rounded-lg mt-n2"
              v-model="credentials.password"
              :append-icon="TampilkanSandi ? 'mdi-eye' : 'mdi-eye-off'"
              :type="TampilkanSandi ? 'text' : 'password'"
              @click:append="TampilkanSandi = !TampilkanSandi"
            ></v-text-field>
          </v-col>

          <v-col>
            <v-btn
              block
              dark
              color="red darken-4"
              class="btn btn-primary rounded-lg text-capitalize mt-n6"
            >
              Masuk
            </v-btn>
          </v-col>

          <v-layout justify-center>
            <p>
              Belum punya akun? Klik 
              <router-link
                to="/Register"
                class="red--text text--darken-4 text-decoration-none"
              >
                Daftar
              </router-link>
            </p>
          </v-layout>
        </v-card-text>
      </v-card>
    </v-layout>
  </v-container>
</template>

<script>
export default {
    data: () => ({

    TampilkanSandi: false,
      credentials:{
        name: '',
        password: ''
      },
    return:{
      loading: true
  
    },

        
  }),
  mounted(){

  },

  methods: {

  },
};

</script>

<style>

</style>