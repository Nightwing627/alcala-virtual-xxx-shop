
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue';
//Rutas del website
import Router from './router.js';

//Librerias globales
import Library from './libs.js';
Vue.use(Library);

//Componentes del website
import components from './components/components.js';
Vue.use(components);

window.Vue=Vue;

//Instancia principal
const app = new Vue({
    el: '#app',
    router:Router,

    data:{
        carritoCount: 0,
        logged:false,
        token:"",
        msgErrorLogin:'',
        user:{
            name:'',
            email:'',
            phone:'',
            customer:{
                street:'',
                num_int:'',
                num_ext:'',
                neighborhood:'',
                postalCode:'',
                state_id:null,
                town_id:null,
            },
        },
    },

    watch:{
        token:function(){
            window.axios.defaults.headers.common['Authorization'] = this.token;
        }
    },

    methods:{
        auth(){
          axios.get(tools.url("/api/me")).then((response)=>{
              this.user = response.data.user;
              this.logged = true;
          }).catch((error)=>{
              console.log(error);
              window.axios.defaults.headers.common['Authorization'] = this.token = "";
              localStorage.removeItem('tokenFront');
          });
        }
    },

    mounted:function(){
    	// console.log(Vue.paypal);
    },

    beforeMount(){
        if(localStorage.tokenFront)
        {
          this.token = localStorage.tokenFront;
          window.axios.defaults.headers.common['Authorization'] = this.token;
          this.auth();
        }
        else
          this.logged = false;
    }
});
