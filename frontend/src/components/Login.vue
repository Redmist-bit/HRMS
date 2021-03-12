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
            <v-subheader class="mx-n4 body-1">Nama</v-subheader>
            <v-text-field
              dense
              outlined
              color="red darken-4"
              class="form-control rounded-lg mt-n2"
              v-model="credentials.Nama"
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
              @keyup.enter="login()"
            ></v-text-field>
          </v-col>

          <v-col>
            <v-btn
              block
              dark
              color="red darken-4"
              class="btn btn-primary rounded-lg text-capitalize mt-n6"
              @click="login()"
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
import api from "@/services/http";
export default {
    data: () => ({

    TampilkanSandi: false,
      credentials:{
        Nama: '',
        password: ''
      },
    return:{
      loading: true
  
    },

        
  }),
  mounted(){

  },

  methods: {
    login(){
      api.post('/login', this.credentials)
        .then(res=>{
          if (res.data.status == false) {
          this.pesan = "Access Denied : Email Atau Password salah"  
          } else {
            console.log(res)
            localStorage.setItem('token', res.data.token)
            localStorage.setItem('user', JSON.stringify(res.data.user))
            location.reload(false)
          }
  
        })
        .catch(err=>{
          alert('email atau password salah')
          console.log(err)
          confirm('email atau password salah')
          console.log('email atau password salah')
        })
    },
  },
};

</script>

<style>

</style>