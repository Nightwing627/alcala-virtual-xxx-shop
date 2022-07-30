<template>
	<div class="row">
		<div class="col-md-offset-1 col-md-10">

			<div class="panel panel-primary" data-collapsed="0">

				<div class="panel-heading">
					<div class="panel-title">
						<i class="fas fa-image"></i> Banners
					</div>
					<div class="panel-options">
						<a @click="$router.push('/banners/')"><i class="fas fa-times"></i></a>
					</div>
				</div>

				<div class="panel-body">
					<form role="form" class="form-horizontal" @submit.prevent="newBanners($event.target)">

						<input-form name="name" text="Nombre" :data.sync="banner.name" ></input-form>
						<div class="form-group">
							<label class="col-sm-3 control-label">Sección del banner</label>
							<div class="col-sm-7">
								<select name="seccion" required="required" v-model="banner.section" class="form-control">
									<option :value="0">Superior Largo</option>
									<option :value="1">Inferior Largo</option>
									<option :value="2">Cuadrado</option>
								</select>
								<!--<input type="number" name="seccion" min="0" max="13" class="form-control" required v-model="banner.section">-->
							</div>
						</div>

						<div class="form-group" v-if="banner.section == 0">
							<label class="col-sm-3 control-label">Dispositivo:</label>
							<div class="col-sm-7">
					              <div class="control-label" style="float:left; padding-left: 20%">					       
					                <input type="radio" id="pc" name="Computadora" :value="true" v-model="banner.device">
					                <label for="pc">Computadora</label>
					              </div>
					              <div class="control-label" style="float:right;padding-right: 20%">					              	
					                <input type="radio" id="mobile" name="Celular" :value="false" v-model="banner.device">
					                <label for="mobile">Celular</label>
					              </div>
							</div>
						</div>

						<input-form name="posicion" text="Posición" type="number" :data.sync="banner.position" validate="required" v-if="banner.section == 0 || banner.section == 2"></input-form>
						<input-form name="url" text="Url" :data.sync="banner.url"></input-form>

						

						<div class="form-group">
							<div class="col-sm-3">
								<label class="col-sm-12 control-label">Banner</label>
							</div>
							<div class="col-sm-9">
								<label class="col-sm-12 control-label" style="text-align: left; padding-bottom: 10px" v-if="banner.section == 0 || banner.section == 1 ">Dimensiones recomendadas (1920 x 562): Celular(375 x 300):</label>
								<label class="col-sm-12 control-label" style="text-align: left; padding-bottom: 10px" v-if="banner.section != 0 && banner.section != 1">Dimensiones recomendadas (503 x 503)</label>
								<div class="fileinput fileinput-new" data-provides="fileinput">
									<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;" data-trigger="fileinput">
										<img :src="banner.imageUrl" alt="..." v-if="id!=''">
										<img src="//placehold.it/200x150?text=Imagen" alt="..." v-else>
									</div>
									<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 400px; max-height: 300px"></div>
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
							<checkbox-form name="active" text="Activo" :data.sync="banner.status"></checkbox-form>
						</div>
						<div class="form-group">
							<div class="col-sm-12">
								<button type="button" class="btn btn-danger" @click="deleteBanners" v-show="$route.params.id"><i class="fa fa-trash"></i> Borrar</button>
								<button type="submit" class="btn btn-success pull-right"><i class="far fa-save"></i> Guardar</button>
								<button type="button" class="btn btn-default pull-right" @click="$router.push('/banners/')">Cancelar</button>
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
				banner:{
					name:"",
					status:true,
					device:true,
					section:0,
					position:"",
					url:"",
				},
				id:"",
	      		check:false,
			}
		},
		methods:{
			getBanners(){
				this.$parent.inPetition=true;
				axios.get(tools.url("/api/banners/"+this.id)).then((response)=>{
			    	this.banner = response.data;
			    	this.banner.status = (this.banner.status)?(true):(false);
			    	this.$parent.inPetition=false;
			    }).catch((error)=>{
			    	this.$parent.handleErrors(error);
			       this.$parent.inPetition=false;
			    });
			},
			newBanners(form){
				this.$parent.inPetition=true;
				this.$parent.validateAll(()=>{
					var data=tools.params(form,this.banner);
					if(this.$route.params.id){
						axios.post(tools.url("/api/banners/"+this.id),data)
						.then((response)=>{
					    	this.getBanners();
					    	this.$parent.showMessage("Banner "+this.banner.name+" modificado correctamente!","success");
					    	this.$parent.inPetition=false;
					    }).catch((error)=>{
					    	this.$parent.handleErrors(error);
					        this.$parent.inPetition=false;
					    });
					}
					else{
						axios.post(tools.url("/api/banners"),data).then((response)=>{
							var banner = response.data;
					    	this.$parent.showMessage("Banner "+banner.name+" agregado correctamente!","success");
					    	this.$router.push('/banners/edit/'+banner.id);
					    	this.$parent.inPetition=false;
					    }).catch((error)=>{
					    	this.$parent.handleErrors(error);
					        this.$parent.inPetition=false;
					    });
					}
				},(e)=>{
					console.log(e);
					this.$parent.inPetition=false;
				});
			},
			deleteBanners:function(){
				alertify.confirm("Alerta!","¿Seguro que deseas borrar este banner?",()=>{
					this.$parent.inPetition=true;
					axios.delete(tools.url("/api/banners/"+this.id))
					.then((response)=>{
						this.$parent.showMessage(response.data.msg,"success");
						this.$router.push("/banners/");
						this.$parent.inPetition=false;
					})
					.catch((error)=>{
						this.$parent.handleErrors(error);
				        this.$parent.inPetition=false;
					});
				},
				()=>{
				});
			},
		},
		mounted(){
			if(this.$route.params.id){
				this.id=this.$route.params.id;
				this.getBanners();
			}
		}
	}
</script>
