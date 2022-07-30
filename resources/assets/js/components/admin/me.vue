<template>
	<div class="row">
		<div class="col-md-offset-1 col-md-10">
			
			<div class="panel panel-primary" data-collapsed="0">
			
				<div class="panel-heading">
					<div class="panel-title">
						<i class="fa fa-user"></i> Usuario
					</div>
					<div class="panel-options">
						<a @click="$router.push('/home/')"><i class="fas fa-times"></i></a>
					</div>
				</div>
				
				<div class="panel-body">
					<form role="form" class="form-horizontal" @submit.prevent="newUser($event.target)">

						<input-form name="nombre" text="Nombre" :data.sync="user.name" validate="alpha_spaces|required|min:5"></input-form>
						<input-form name="email" text="Email" :data.sync="user.email" validate="email|required"></input-form>
						<input-form type="password" name="password" text="Password" :data.sync="user.password" :validate="rule_password" place="Solo si desea cambiarla"></input-form>
						<input-form type="tel" name="telefono" text="Telefono" :data.sync="user.phone" validate="digits:8"></input-form>
						<input-form type="tel" name="celular" text="Celular" :data.sync="user.celphone" validate="digits:10"></input-form>
							
					
						<div class="form-group">
							<label class="col-sm-3 control-label">Foto:</label>
							
							<div class="col-sm-7">
								
								<div class="fileinput fileinput-new" data-provides="fileinput">
									<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;" data-trigger="fileinput">
										<img :src="'/img/'+user.img.key" alt="...">
									</div>
									<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px"></div>
									<div>
										<span class="btn btn-white btn-file">
											<span class="fileinput-new">Select image</span>
											<span class="fileinput-exists">Change</span>
											<input type="file" accept="image/*" name="image">
										</span>
										<a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>
									</div>
								</div>
								
							</div>
						</div>

																
						<div class="form-group">
							<div class="col-sm-12">
								
								<button type="submit" class="btn btn-success pull-right"><i class="far fa-save"></i> Guardar</button> 
								<button type="button" class="btn btn-default pull-right" @click="$router.push('/home/')">Cancelar</button>
							</div>
						</div>
					</form>					
				</div>			
			</div>		
		</div>

	</div>
</template>
<script type="text/javascript">
	export default {
		data(){
			return {
				user:{
					name:"",
					email:"",
					password:"",
					phone:"",
					celphone:"",
					access:0,
					roles:[],
					img:{key:""},
				},				
				
			}
		},
		computed:{
			rule_password:function(){
				if(this.user.password==undefined || this.user.password.length==0){
					return '';
				}
				else{
					return 'min:5|required';
				}
			},
		},
		methods:{
			newUser(form){				
				this.$parent.inPetition=true;
				this.$parent.validateAll(()=>{

					var data=tools.params(form,this.user);
					
					axios.post(tools.url("/api/me"),data)
					.then((response)=>{
				    	this.$parent.auth();
				    	this.$parent.showMessage("Tu perfil a sido modificado correctamente!","success");
				    	this.$parent.inPetition=false;
				    }).catch((error)=>{
				    	this.$parent.handleErrors(error);
				        this.$parent.inPetition=false;
				    });
					
				},(e)=>{
					console.log(e);
					this.$parent.inPetition=false;
				});				
			},

		},
		mounted(){
			this.user=this.$parent.user;
		}
	}
</script>