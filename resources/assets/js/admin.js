
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue';
//Rutas de admin
import Router from './routerAdmin.js';

//Librerias globales
import Library from './libs.js';
Vue.use(Library);

import VueEditor  from 'vue2-editor';
Vue.use(VueEditor);

//Componentes del dashboard
import componentsAdmin from './components/componentsAdmin.js';
Vue.use(componentsAdmin);


//Instancia principal
var app = new Vue({
    el: '#app',
    router:Router,
    data:{
        inPetition:false,
    	logged:false,
    	token:"",
        validForm:true,
        alert:{
            class:"info",
            msg:""
        },
    	user:{
    		name:"",
    		password:"",
    		email:"",
    		celphone:"",
    		phone:"",
    		access:"",
    		image_id:"",
    		created_at:"",
    		updated_at:""
    	}
    },
    watch:{
    	token:function(){
    		window.axios.defaults.headers.common['Authorization'] = this.token;
    	}
    },
    methods:{
    	auth:function(){
    		axios.get(tools.url("/api/me")).then((response)=>{
		    	this.user=response.data.user;
		    	this.logged=true;
		    	if(this.$route.path=="/login"){
		    		this.$router.push('/home');
		    	}
                this.alert.msg="Bienvenido "+this.user.name;
                tools.push("Bienvenido "+this.user.name);
		        
		    }).catch((error)=>{
		    	console.log(error);
		    	if(error.response){
		        	this.error=error.response.data.error;
		    	}else{
		    		this.error="Error inesperado.";
		    	}
		        this.token="";
		    });
    	},
        showMessage:function(msg,xclass="info"){
            this.alert.msg="";

            setTimeout(()=>{
                this.alert.class=xclass;
                this.alert.msg=msg;
            },200);
        },
        handleErrors:function(errors){
            var err="";

            if (errors.response) {
                if(errors.response.data.message){
                    err+=errors.response.data.message+"<br>";
                }
                if(errors.response.data.msg){
                    err+=errors.response.data.msg+"<br>";
                }
                if(errors.response.data.errors){
                    jQuery.each(errors.response.data.errors,(k,v)=>{
                        err+="*"+k+": "+v[0]+"<br>";
                    });
                }
            }
            else{
                console.log(errors);
                err="Error desconocido.";
            }

            this.showMessage(err,"danger");

        },
        validateAll:function(successFn,errorFn){
            
            let promises = [];
            let isValid=false;

            for (let child in this.$refs.view.$children) {
                promises.push(this.$refs.view.$children[child].$validator.validateAll())
            }

            
            Promise.all(promises)
            .then(this.$validator.validateAll())
            .then((error) => {
                let errors=[];
                if (error.indexOf(false)!=-1) {
                    isValid=false;
                    for (let child in this.$refs.view.$children) {
                        errors.push(this.$refs.view.$children[child].errors.all());
                    }
                    errors=jQuery.map(errors,(row)=>{
                        if(row[0])
                            return row;
                    });
                    this.showMessage("Existen campos invalidos","danger");
                    if(typeof errorFn === 'function') {
                        errorFn();
                    }
                }
                else{
                    
                    if(typeof successFn === 'function') {
                        successFn();
                    }
                }
            });
                           
        },
    },
    mounted:function(){
    	if(localStorage.token){
    		
    		this.token=localStorage.token;
    		window.axios.defaults.headers.common['Authorization'] = this.token;
    		this.auth();
    	}

    }
});