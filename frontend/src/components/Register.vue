<template>
  <v-layout class="mt-5" justify-center>
    <v-col cols="12" md="6" sm="6">
      <v-card
        outlined
        scrollable
        max-width="900"
        class="mx-auto elevation-15 rounded-lg"
      >
        <v-layout justify-center>
          <v-card-title class="headline">
            Daftar Akun
          </v-card-title>
        </v-layout>

        <v-layout class="mt-n8" row wrap align-center justify-center>
          <p class="subheading font-weight-regular grey--text text--darken-1 my-4">
            Sudah Punya Akun? Klik
            <router-link
              to="/Login"
              class="red--text text--darken-4 text-decoration-none"
            >
              Masuk
            </router-link>
          </p>
        </v-layout>

        <v-card-text class="mt-n4">
          <v-col>
            <v-row dense>

              <!-- Nama -->
              <v-col cols="12" md="6">
                <v-text-field
                  dense
                  outlined
                  class="rounded-lg"
                  color="grey darken-1"
                  v-model="Nama"
                  label="Nama"
                  :rules="nameRules"
                >
                </v-text-field>
              </v-col>

              <!-- Password -->
              <v-col cols="12" md="6">
                <v-text-field
                  dense
                  outlined
                  class="rounded-lg"
                  color="grey darken-1"
                  v-model="password"
                  :append-icon="TampilkanPassword ? 'mdi-eye' : 'mdi-eye-off'"
                  :rules="[rules.required, rules.min]"
                  :type="TampilkanPassword ? 'text' : 'password'"
                  name="input-10-1"
                  label="Kata Sandi"
                  hint="Min 6 Karakter"
                  persistent-hint
                  counter
                  @click:append="TampilkanPassword = !TampilkanPassword"
                ></v-text-field>
              </v-col>

              <!-- Ulangi Password -->
              <!-- <v-col cols="12" md="6">
                <v-text-field
                  dense
                  outlined
                  class="rounded-lg"
                  color="grey darken-1"
                  v-model="password2"
                  :append-icon="TampilkanPassword2 ? 'mdi-eye' : 'mdi-eye-off'"
                  :rules="[rules.required, rules.min]"
                  :type="TampilkanPassword2 ? 'text' : 'password'"
                  name="input-10-1"
                  label="Konfirmasi Sandi"
                  hint="Min 6 Karakter"
                  persistent-hint
                  counter
                  @click:append="TampilkanPassword2 = !TampilkanPassword2"
                ></v-text-field>
              </v-col> -->
            </v-row>
          </v-col>
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-spacer></v-spacer>
          <!-- <v-btn
            dark
            color="error"
            @click="close">
            <v-icon class="mr-1">mdi-close-circle</v-icon>Batal
          </v-btn> -->
          <v-btn
            dark
            block
            color="red darken-4 rounded-lg"
            class="text-capitalize"
            @click="save">
            <v-icon class="mr-1">mdi-account-plus</v-icon>Daftar
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-col>
  </v-layout>
</template>

<script>
import api from '../services/http'
export default {
    data() {
        return {
          d: new Date(),
          date: new Date().toISOString().substr(0, 10),
          tglanlahir:'',
          Nama:"",
          password:"",

					nameRules: [
						value => !!value || 'Nama Wajib Diisi.',
					],

					emailRules: [
						v => !!v || 'E-mail Wajib Diisi',
						v => /.+@.+\..+/.test(v) || 'E-mail Harus Benar',
					],
					
					rules: {
						required: value => !!value || 'Kata Sandi Wajib Diisi.',
						min: v => v.length >= 6 || 'Setidaknya 6 Karakter',
						// emailMatch: () => (`The email and password you entered don't match`),
					},
					TampilkanPassword: false,
          TampilkanPassword2: false,
          editedIndex: -1,
          defaultItem: {
          name: "",
          email: "",
          password: "",
        },

          editedItem: {
          name: "",
          email: "",
          password: "",
				},
				
        token : localStorage.getItem('token'),
      }
    },

    mounted(){
        // this.getDataRegister()
        
    },
    
     watch: {
       date(){
         var tahun = this.date.substring(0, 4);
         let bulan = this.date.substring(5, 7);
         let tgl = this.date.substring(8, 10);
         this.TglLahir =  tahun+"/"+bulan+"/"+tgl
         this.tglanlahir = this.TglLahir
       }
     },
    computed: {
        
    },
    methods: {
        save(){
          let today = this.d.getFullYear() +"/"+("0" + (this.d.getMonth()+1)).slice(-2) +"/"+("0" + this.d.getDate()).slice(-2) + " "
          if (this.password != this.password2) {
            alert ('Pastikan Password telah benar')
          } else {
            api.post('/register',{
              Kode: "0101/"+this.Nama,
              Nama: this.Nama,
              Email: this.Email,
              password: this.password,
              UserMenu: 0,
              DibuatOleh: "SYS ADMIN",
              DiBuatTgl:today,
              DiubahOleh: "SYS ADMIN",
              DiubahTgl:today
            })
            .then((res)=>{
              if (res.data.status == true) {
                alert('Selamat, Register telah berhasil,')
                localStorage.setItem('token', res.data.token)
                localStorage.setItem('user', JSON.stringify(res.data.user))
                this.$router.push('/')
              } else {
                alert('email sudah digunakan')
              }
            })
            .catch((err)=>{
              console.log(err)
              alert('Pastikan data sudah terisi dengan benar')
            })
          }
        },


    }
}
</script>
