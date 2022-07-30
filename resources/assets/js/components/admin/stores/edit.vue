<template>
	<div class="row">
		<div class="col-md-offset-1 col-md-10">

			<div class="panel panel-primary" data-collapsed="0">

				<div class="panel-heading">
					<div class="panel-title">
						<i class="fas fa-image"></i> Tiendas
					</div>
					<div class="panel-options">
						<a @click="$router.push('/stores/')"><i class="fas fa-times"></i></a>
					</div>
				</div>

				<div class="panel-body">
					<form role="form" class="form-horizontal" @submit.prevent="newContent($event.target)">

						<input-form name="name" text="Nombre" :data.sync="content.name"></input-form>

						<div class="form-group">
							<label for="editor2" class="col-sm-3 control-label">Descripción</label>
							<div class="col-sm-7">
								<vue-editor id="editor2" v-model="content.description"
									:editor-toolbar="[['bold', 'italic', 'underline'],[{ list: 'ordered' }, { list: 'bullet' }]]">
								</vue-editor>
							</div>
						</div>

						<input-form name="facebook" text="Facebook URL" :data.sync="content.facebook"></input-form>
						
						<div class="form-group">
							<div class="col-sm-12">
								<button type="submit" class="btn btn-success pull-right"><i class="far fa-save"></i> Guardar</button>
								<button type="button" class="btn btn-default pull-right" @click="$router.push('/stores/')">Cancelar</button>
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
				content:{
					name: '',
					description: '',
					facebook: ''
				},
				
				id: '',
				check:false,
			}
		},
		methods:{

			getContent(){
				this.$parent.inPetition=true;
				axios.get(tools.url("/api/stores/"+this.id)).then((response)=>{
			    	this.content = response.data;
					this.$parent.inPetition=false;
			    }).catch((error)=>{
			    	this.$parent.handleErrors(error);
			       this.$parent.inPetition=false;
			    });
			},

			newContent(form){
				this.$parent.inPetition=true;
				this.$parent.validateAll(()=>{
					var data = tools.params(form, this.content);
					if(this.$route.params.id){
						axios.post(tools.url("/api/stores/"+this.id),data)
						.then((response)=>{
					    	this.getContent();
					    	this.$parent.showMessage("Tienda "+ this.content.name +" modificada correctamente!","success");
					    	this.$parent.inPetition=false;
					    }).catch((error)=>{
					    	this.$parent.handleErrors(error);
					        this.$parent.inPetition=false;
					    });
					}
					else{
						axios.post(tools.url("/api/stores"), data).then((response)=>{
							var temp = response.data;
					    	this.$parent.showMessage("Tienda "+ temp.name +" agregado correctamente!","success");
					    	this.$router.push('/stores/edit/'+temp.id);
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
			}
		},
		mounted(){
			if(this.$route.params.id){
				this.id = this.$route.params.id;
				this.getContent();
			}
		}
	}
</script>
