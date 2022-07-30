<template>
	<div class="row">
		<div class="col-md-offset-1 col-md-10">
			
			<div class="panel panel-primary" data-collapsed="0">
			
				<div class="panel-heading">
					<div class="panel-title">
						<i class="fa fa-angle-right"></i> Garantías y confidencialidad
					</div>
					
				</div>
				
				<div class="panel-body">
					<form role="form" class="form-horizontal" @submit.prevent="submit($event.target)">

						<div class="form-group">
							<label for="editor2" class="col-sm-3 control-label">Cuerpo</label>
							<div class="col-sm-7" style="padding: 0rem 5rem 0rem 5rem;">
								<vue-editor id="editor2"  v-model="content.body" :editorToolbar="customToolbar"></vue-editor>
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

				content:{
					id:null,
					body:''
					
				},
				id:8,
				
			}
		},
		
		methods:{
			getContent(){
				this.$parent.inPetition=true;
				axios.get(tools.url("/api/garantia")).then((response)=>{
			    	this.content = response.data;
			    	this.$parent.inPetition=false;
			    }).catch((error)=>{
			    	this.$parent.handleErrors(error);
			        this.$parent.inPetition=false;
			    });
			},
			submit(form){			

				this.$parent.inPetition=true;
				this.$parent.validateAll(()=>{
	
					var data=tools.params(form, this.content);					

					axios.post(tools.url("/api/garantia"),data).then((response)=>{
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
			this.getContent();
		}
	}
</script>