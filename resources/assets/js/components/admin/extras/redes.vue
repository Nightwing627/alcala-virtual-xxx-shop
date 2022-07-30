<template>
	<div class="row">
		<div class="col-md-offset-1 col-md-10">
			
			<div class="panel panel-primary" data-collapsed="0">
			
				<div class="panel-heading">
					<div class="panel-title">
						<i class="fa fa-angle-right"></i> Redes Sociales
					</div>
					
				</div>
				
				<div class="panel-body">
					<form role="form" class="form-horizontal" @submit.prevent="submit($event.target)">

						<input-form name="facebook" text="Url Facebook" :data.sync="redes.facebook" validate="required"></input-form>	

						<input-form name="instagram" text="Url Instagram" :data.sync="redes.instagram" validate="required"></input-form>

						<input-form name="youtube" text="Url Youtube" :data.sync="redes.youtube" validate="required"></input-form>	

						<input-form name="email" text="Email de Contacto" :data.sync="redes.email" validate="required"></input-form>	

						<input-form name="telefono" text="Teléfono" :data.sync="redes.telefono" validate="required"></input-form>	

						<input-form name="address" text="Dirección" :data.sync="redes.address" validate="required"></input-form>	
							

						<div class="form-group">
							<div class="col-sm-12">
								
								<button type="submit" class="btn btn-success pull-right"><i class="far fa-save"></i> Guardar</button> 
										
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

				redes:{
					id:null,
					facebook:'',
					instagram:'',
					youtube: '',
					email:'',
					telefono:'',
					address: ''
				},
				id:4,
				
			}
		},
		
		methods:{
			getRedes(){
				this.$parent.inPetition=true;
				axios.get(tools.url("/api/redes")).then((response)=>{
			    	this.redes = response.data;
			    	this.$parent.inPetition=false;
			    }).catch((error)=>{
			    	this.$parent.handleErrors(error);
			        this.$parent.inPetition=false;
			    });
			},
			submit(form){			

				this.$parent.inPetition=true;
				this.$parent.validateAll(()=>{
	
					var data=tools.params(form,this.redes);					

					axios.post(tools.url("/api/redes"),data).then((response)=>{
				    	this.$parent.showMessage("Redes Sociales actualizadas correctamente!","success");
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
			this.getRedes();
		}
	}
</script>