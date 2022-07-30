<template>
	<div class="row">
		<div class="col-md-offset-1 col-md-10">
			
			<div class="panel panel-primary" data-collapsed="0">
			
				<div class="panel-heading">
					<div class="panel-title">
						<i class="fa fa-angle-right"></i> Historia
					</div>
					
				</div>
				
				<div class="panel-body">
					<form role="form" class="form-horizontal" @submit.prevent="submit($event.target)">

						
						<!-- <div class="form-group">
							<label class="col-sm-3 control-label">Imagen:</label>
							
							<div class="col-sm-7">
								
								<div class="fileinput fileinput-new" data-provides="fileinput">
									<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;" data-trigger="fileinput">
										<img :src="historia.imageUrl" alt="..." v-if="id!=''">
										<img src="//placehold.it/200x150?text=Imagen" alt="..." v-else>
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
						</div> -->

						<div class="form-group">
							<label for="editor2" class="col-sm-3 control-label">Mision</label>
							<div class="col-sm-7" style="padding: 0rem 5rem 0rem 5rem;">
								<vue-editor id="editor2"  v-model="historia.mision" :editorToolbar="customToolbar"></vue-editor>
							</div>
						</div>				

						<div class="form-group">
							<label for="editor2" class="col-sm-3 control-label">Vision</label>
							<div class="col-sm-7" style="padding: 0rem 5rem 0rem 5rem;">
								<vue-editor id="editor2"  v-model="historia.vision" :editorToolbar="customToolbar"></vue-editor>
							</div>
						</div>

						<div class="form-group">
							<label for="editor2" class="col-sm-3 control-label">Valores</label>
							<div class="col-sm-7" style="padding: 0rem 5rem 0rem 5rem;">
								<vue-editor id="editor2"  v-model="historia.valores" :editorToolbar="customToolbar"></vue-editor>
							</div>
						</div>					

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

				customToolbar: [
					[{ 'font': [] }],
					[{ 'header': [false, 1, 2, 3, 4, 5, 6, ] }],
					['bold', 'italic', 'underline'],
					[{'align': ''}, {'align': 'center'}, {'align': 'right'}, {'align': 'justify'}],
					[{ 'list': 'ordered'}, { 'list': 'bullet' }]//,
					//['image', 'code-block']
				],

				historia:{
					id:null,
					historia:'',
					nosotros:'',
					mision:'',
					vision: '',
					valores: '',
					imageUrl:'',
				},
				id:1,
				
			}
		},
		
		methods:{
			getHistoria(){
				this.$parent.inPetition=true;
				axios.get(tools.url("/api/historia")).then((response)=>{
			    	this.historia = response.data;
			    	this.$parent.inPetition=false;
			    }).catch((error)=>{
			    	this.$parent.handleErrors(error);
			        this.$parent.inPetition=false;
			    });
			},
			submit(form){			

				this.$parent.inPetition=true;
				this.$parent.validateAll(()=>{
	
					var data=tools.params(form,this.historia);					

					axios.post(tools.url("/api/historia"),data).then((response)=>{
				    	this.$parent.showMessage("Información actualizada correctamente!","success");
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
			this.getHistoria();
		}
	}
</script>