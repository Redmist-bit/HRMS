import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'
import About from '../views/About.vue'
import Login from '../components/Login.vue'
import Register from '../components/Register.vue'
import Karyawan from '../components/Karyawan.vue'
import UserMenu from '../components/UserMenu.vue'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/about',
    name: 'About',
    component: About
  },
  {
    path: '/login',
    name: 'Login',
    component: Login
  },
  {
    path: '/register',
    name: 'Register',
    component: Register
  },
  {
    path: '/karyawan',
    name: 'Karyawan',
    component: Karyawan
  },
  {
    path: '/usermenu',
    name: 'UserMenu',
    component: UserMenu
  },
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
