<template>
	<div class="row">
		<div class="col-md-offset-1 col-md-10">

			<div class="panel panel-primary" data-collapsed="0">

				<div class="panel-heading">
					<div class="panel-title">
						<i class="fas fa-box"></i> Productos
					</div>
					<div class="panel-options">
						<a @click="$router.push('/products/')"><i class="fas fa-times"></i></a>
					</div>
				</div>

				<div class="panel-body">
					

					<div id="tabs">
						<ul class="nav nav-tabs">
							<li :class="activeInfo"><a @click="active = 1" href="#1" data-toggle="tab">Información</a></li>
						</ul>


						<div class="tab-content">

							<div :class=" 'tab-pane ' + activeInfo" id="1">
								<form role="form" class="form-horizontal" @submit.prevent="newProducto($event.target)">

									<input-form name="sku" text="SKU" :data.sync="producto.sku" validate="required"></input-form>
									<input-form name="nombre" text="Nombre" :data.sync="producto.name" validate="required"></input-form>

									<div class="form-group">
										<label for="editor2" class="col-sm-3 control-label">Descripción</label>
										<div class="col-sm-7">
											<vue-editor id="editor2" v-model="producto.description"
												:editor-toolbar="[['bold', 'italic', 'underline'],[{ list: 'ordered' }, { list: 'bullet' }]]">
											</vue-editor>
										</div>
									</div>

									<input-form type="decimal" name="precio" text="Precio" :data.sync="producto.price"></input-form>
									<input-form type="number" name="stock" text="cantidad (stock)" :data.sync="producto.stock"></input-form>
									<input-form name="measure" text="Medidas" :data.sync="producto.measure"></input-form>
									<input-form name="weight" text="Peso (kg)" :data.sync="producto.weight"></input-form>

									<div class="form-group">
										<label class="col-sm-3 control-label">Categoria:</label>
										<div class="col-sm-7">
											<v-select v-model="producto.category_id" :options="categories" label="name" index="id" @change="getSubcategories(producto.category_id);"/>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 control-label">Subcategoria:</label>
										<div class="col-sm-7">
											<v-select v-model="producto.subcategory_id" :options="subcategories" label="name" index="id"/>
										</div>
									</div>

									<input-form name="tags" text="Palabras claves" :data.sync="producto.tags"></input-form>

									<div class="form-group">
										<label class="col-sm-3 control-label">Video demostrativo:</label>
										<div class="col-sm-7 text-center">
											<input type="file" name="video" accept="video/*">
										
										</div>
									</div>

									<div class="form-group" v-if="producto.videoUrl">
										<label class="col-sm-3 control-label">Previa</label>
										<div class="col-sm-7 text-center">
											<iframe :src="producto.videoUrl" width="100%"></iframe>
										</div>
									</div>


									<div class="form-group">
										<label class="col-sm-3 control-label">Foto:</label>

										<div class="col-sm-7">

											<div class="fileinput fileinput-new" data-provides="fileinput">
												<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;"
													data-trigger="fileinput">
													<img :src="producto.imageUrl" alt="..." v-if="id!=''">
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

									<div class="form-group pt-5" v-if="id">
										<div class="col-md-12">
											<p>* Las imágenes deben tener un tamaño menor a 3 MB</p>
											<vue-dropzone ref="VueDropzone" id="dropzone" :options="dropzoneOptions" @vdropzone-complete="onUpload"></vue-dropzone>
											<div class="row">
												<div class="col-md-12" v-if="images.length > 0">
													<h3>Imagenes del producto</h3>
													<div class="row gallery-container">
														<div class="col-md-2" v-for="(image, index) in images" :key="index">
															<img :src="image.url" class="img-thumbnail" @click="deleteImage(image.id)">
														</div>
													</div>
												</div>
											</div>													
										</div>
									</div>

									<div class="form-group">
										<div class="col-sm-12">
											<button type="submit" class="btn btn-success pull-right"><i class="far fa-save"></i>
												Guardar</button>
											<button type="button" class="btn btn-default pull-right"
												@click="$router.push('/products/')">Cancelar</button>
										</div>
									</div>

								</form>
							</div>

						</div>
					</div>	




				</div>
			</div>
		</div>

	</div>
</template>
<script type="text/javascript">
	export default {
		data(){
			return {
				producto:{
					name: '',
					sku: '',
					description: '',
					price: 0,
					stock: 0,
					measure: '',
					weight: '',
					category_id: null,
					subcategory_id: null,
					tags: '',
				},

				categories: [],
				subcategories: [],
				
				id: '',
				check:false,
				active:1,
				images: [],

				//Variables para la galeria
				dropzoneOptions: {
		     		url: tools.url('/api/productImage/' + this.$route.params.id),
		            headers: { 'Authorization': this.$parent.token },
		            acceptedFiles:'image/*',
		            uploadMultiple:false,
		            maxFilesize:3,
		        },
			}
		},

		computed:{
			activeInfo: function()
			{
				return (this.active == 1) ? 'active' : '';
			},

			activeVariantes: function()
			{
				return (this.active == 2) ? 'active' : '';
			}
		},

		methods:{

			getProducto(){
				this.$parent.inPetition=true;
				axios.get(tools.url("/api/products/"+this.id)).then((response)=>{
			    	this.producto = response.data;
					this.$parent.inPetition=false;
			    }).catch((error)=>{
			    	this.$parent.handleErrors(error);
			       this.$parent.inPetition=false;
			    });
			},

			newProducto(form){
				this.$parent.inPetition=true;
				this.$parent.validateAll(()=>{
					var data=tools.params(form, this.producto);
					if(this.$route.params.id){
						axios.post(tools.url("/api/products/"+this.id),data)
						.then((response)=>{
					    	this.getProducto();
					    	this.$parent.showMessage("Producto "+ this.producto.name +" modificado correctamente!","success");
					    	this.$parent.inPetition=false;
					    }).catch((error)=>{
					    	this.$parent.handleErrors(error);
					        this.$parent.inPetition=false;
					    });
					}
					else{
						axios.post(tools.url("/api/products"),data).then((response)=>{
							var temp = response.data;
					    	this.$parent.showMessage("Producto "+ temp.name +" agregado correctamente!","success");
					    	this.$router.push('/products/edit/'+temp.id);
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

			//selects
			getCategories(){
				this.$parent.inPetition=true;
				axios.get(tools.url("/api/categories")).then((response)=>{
			    	this.categories = response.data;
					this.$parent.inPetition=false;

			    }).catch((error)=>{
			    	this.$parent.handleErrors(error);
			       this.$parent.inPetition=false;
			    });
			},

			getSubcategories(id){
				this.$parent.inPetition=true;
				if(id){
					axios.get(tools.url("/api/getSubcategories/"+id)).then((response)=>{
						this.subcategories = response.data.subcategories;
					});
				}
				this.$parent.inPetition=false;
			},


			/********* Métodos para la galeria del producto ********************/
			
			//Manejador de evento onUpload del dropZone
			onUpload(file, response) {
				setTimeout(() => {
		        	let vueDropzone = this.$refs['VueDropzone'];
					vueDropzone.removeFile(file);
					this.getRelatedImages(this.id);
				}, 1000);
				
			},

			//Obtener el listado de imagenes del paquete
			getRelatedImages(id) {
				axios.get(tools.url("/api/productImage/" + this.id )).then(result => {
					this.images = [];
					result.data.forEach(image => this.images.push(image));
					this.$parent.inPetition = false;
				}).catch(error => {
					alert("No se pudo obtener las imagenes");
					this.$parent.handleErrors(error);
					this.$parent.inPetition = false;
				});
			},

			//Borrar una image de la galeria del paquete
			deleteImage(id) {
				alertify.confirm("Alert!","¿Seguro que desea eliminar de forma permanente esta imagen?",() => {
					axios.delete(tools.url("/api/productImage/" + id )).then(result => {
						this.getRelatedImages(this.id);
						this.$parent.showMessage(result.data.msg, "success");
						this.$parent.inPetition = false;
					}).catch(error => {
						this.$parent.handleErrors(error);
						this.$parent.inPetition = false;
					});
				}, ()=>{});
			}
		},

		mounted(){
			this.getCategories();

			if(this.$route.params.id){
				this.id = this.$route.params.id;
				this.getProducto();
				this.getRelatedImages(this.id);
				this.getSubcategories(this.producto.category_id);
			}
		}
	}
</script>
