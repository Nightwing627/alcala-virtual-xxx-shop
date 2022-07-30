<template>
	<div class="row">
		<div class="col-md-offset-1 col-md-10">

			<div class="panel panel-primary" data-collapsed="0">

				<div class="panel-heading">
					<div class="panel-title">
						<i class="fas fa-image"></i> Categorias
					</div>
					<div class="panel-options">
						<a @click="$router.push('/categorias/')"><i class="fas fa-times"></i></a>
					</div>
				</div>

				<div class="panel-body">
					<form role="form" class="form-horizontal" @submit.prevent="newCategoria($event.target)">

						<input-form name="name" text="Nombre" :data.sync="categoria.name"></input-form>

						<div class="form-group">
							<label class="col-sm-3 control-label">Foto:</label>
							<div class="col-sm-7">
								<label>Dimensiones recomendadas (1920 x 170)</label><br/>
								<div class="fileinput fileinput-new" data-provides="fileinput">
									<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;"
										data-trigger="fileinput">
										<img :src="categoria.imageUrl" alt="..." v-if="id!=''">
										<img src="//placehold.it/200x150?text=Imagen" alt="..." v-else>
									</div>
									<div class="fileinput-preview fileinput-exists thumbnail"
										style="max-width: 200px; max-height: 150px"></div>
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
								<button type="button" class="btn btn-danger" @click="deleteRow" v-show="$route.params.id"><i class="fa fa-trash"></i> Borrar</button>
								<button type="submit" class="btn btn-success pull-right"><i class="far fa-save"></i> Guardar</button>
								<button type="button" class="btn btn-default pull-right" @click="$router.push('/categorias/')">Cancelar</button>
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
				categoria:{
					name: ''
				},
				
				id: '',
				check:false,
				subcategories: [],
			}
		},
		methods:{

			getCategoria(){
				this.$parent.inPetition=true;
				axios.get(tools.url("/api/categories/"+this.id)).then((response)=>{

			    	this.categoria = response.data;
					this.$parent.inPetition=false;
					
			    }).catch((error)=>{
			    	this.$parent.handleErrors(error);
			       this.$parent.inPetition=false;
			    });
			},

			newCategoria(form){
				this.$parent.inPetition=true;
				this.$parent.validateAll(()=>{
					var data=tools.params(form, this.categoria);
					if(this.$route.params.id){
						axios.post(tools.url("/api/categories/"+this.id),data)
						.then((response)=>{
					    	this.getCategoria();
					    	this.$parent.showMessage("Categoria "+ this.categoria.name +" modificada correctamente!","success");
					    	this.$parent.inPetition=false;
					    }).catch((error)=>{
					    	this.$parent.handleErrors(error);
					        this.$parent.inPetition=false;
					    });
					}
					else{
						axios.post(tools.url("/api/categories"),data).then((response)=>{
							var temp = response.data;
					    	this.$parent.showMessage("Categoria "+ temp.name +" agregado correctamente!","success");
					    	this.$router.push('/categorias/edit/'+temp.id);
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

			deleteRow:function(){
				alertify.confirm("Alerta!","¿Seguro que deseas borrar?",()=>{
					this.$parent.inPetition=true;
					axios.delete(tools.url("/api/categories/"+this.id))
					.then((response)=>{
						this.$parent.showMessage(response.data.msg,"success");
						this.$router.push("/categorias/");
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
				this.getCategoria();
			}
		}
	}
</script>
