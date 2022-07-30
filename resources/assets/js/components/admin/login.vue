<template>
	<main role="main">
	<div :class="{'logging-in login-form-fall':inPetition,'page-body login-page':2>1}" style="background: #a53c94;">
	<div class="login-container">
	
		<div class="login-header login-caret" style="background: white none repeat scroll 0% 0%;">
			
			<div class="login-content">
				
				<a class="logo">
					<img :src="logo()" width="300" alt="" />
				</a>
				<p class="description">Usuario, ingresa para entrar al area de administracion!</p>
				
				<!-- progress bar indicator -->
				<div class="login-progressbar-indicator">
					<h3>{{percent}}%</h3>
					<span>Ingresando...</span>
				</div>
			</div>
			
		</div>
		
		<div class="login-progressbar">
			<div :style="'width:'+percent+'%'"></div>
		</div>
		
		<div class="login-form">
			
			<div class="login-content">
				
				<div class="form-login-error" style="display:block;" v-show="error">
					<h3>Error</h3>
					<p>{{error}}</p>
				</div>
				
				<form method="post" @submit.prevent="login">
					
					<div class="form-group">
						
						<div class="input-group">
							<div class="input-group-addon">
								<i class="entypo-user"></i>
							</div>
							
							<input type="text" class="form-control" placeholder="Email" v-model="credentials.email">
						</div>
						
					</div>
					
					<div class="form-group">
						
						<div class="input-group">
							<div class="input-group-addon">
								<i class="entypo-key"></i>
							</div>
							
							<input type="password" class="form-control" placeholder="Password" v-model="credentials.password">
						</div>
					
					</div>
					
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block btn-login">
							<i class="entypo-loginentypo-login"></i>
							Ingresar
						</button>
					</div>
					
				</form>
				
				
				<div class="login-bottom-links">
					
					<!-- <a class="link">Olvide mi contraseña</a> -->
					
									
				</div>
				
			</div>
			
		</div>
		
	</div>
	</div>
	</main>
</template>

<script type="text/javascript">
	export default {
        mounted() {
            console.log('Login mounted.');
        },
        methods:{
        	login(){
        		this.percent=50;
        		this.inPetition=true;
        		axios.post(tools.url("/api/login"),this.credentials).then((response)=>{
			    	this.$parent.user=response.data.user;
			    	this.$parent.token=response.data.token;
			    	localStorage.setItem("token",this.$parent.token);
			    	this.$parent.logged=true;
			    	this.$parent.showMessage("Bienvenido "+this.$parent.user.name);
			    	if(this.$route.path=="/login"){
			    		this.$router.push('/home');
			    	}
			        this.inPetition=false;
			        this.error=false;
			    }).catch((error)=>{
			        this.error=error.response.data.error;			        
			        this.inPetition=false;
			    });
        	},
			logo(){
				return window.tools.url('public/images/logo.png');
			}        	
        },
        data:function(){
        	return {
        		inPetition:false,
        		percent:0,
        		error:false,
        		credentials:{
        			email:"",
        			password:""
        		}
        	}
        }
    }
</script>