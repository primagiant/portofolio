require('./bootstrap');

window.Vue = require('vue').default;

import Admin from './admin/App.vue';
import PembimbingAkademik from './pembimbingAkademik/App.vue';
import Mahasiswa from './mahasiswa/App.vue';

import VueAxios from 'vue-axios';
import VueRouter from 'vue-router';
import axios from 'axios';

import { AdminRoutes } from './routes/admin';
import { PembimbingAkademikRoutes } from './routes/pembimbingAkademik';
import { MahasiswaRoutes } from './routes/mahasiswa';

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.all';

import Vue from 'vue';

Vue.use(VueRouter);
Vue.use(VueSweetalert2);
Vue.use(VueAxios, axios);

Vue.component('pagination', require('laravel-vue-pagination'));

var admin = document.getElementById('admin');
var pembimbingAkademik = document.getElementById('pembimbingAkademik');
var mahasiswa = document.getElementById('mahasiswa');

if (admin !== null) {
    // Admin
    const AdminRouter = new VueRouter({
        mode: 'history',
        routes: AdminRoutes
    });
    
    const admin = new Vue({
        el: '#admin',
        router: AdminRouter,
        render: h => h(Admin)
    });
} else if(pembimbingAkademik !== null) {
    // Pembimbing Akademik
    const PembimbingAkademikRouter = new VueRouter({
        mode: 'history',
        routes: PembimbingAkademikRoutes
    });
    
    const pembimbingAkademik = new Vue({
         el: '#pembimbingAkademik',
         router: PembimbingAkademikRouter,
         render: h => h(PembimbingAkademik)
    });
} else if (mahasiswa !== null) {
    // Mahasiswa
    const MahasiswaRouter = new VueRouter({
        mode: 'history',
        routes: MahasiswaRoutes
    });
    
    const mahasiswa = new Vue({
         el: '#mahasiswa',
         router: MahasiswaRouter,
         render: h => h(Mahasiswa)
    });
}




 