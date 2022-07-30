<template>
	<div class="row">
		<div class="col-md-offset-1 col-md-10">
			
			<div class="panel panel-primary" data-collapsed="0">
			
				<div class="panel-heading">
					<div class="panel-title">
						<i class="fa fa-angle-right"></i> Titulos del Home
					</div>
					
				</div>
				
				<div class="panel-body">
					<form role="form" class="form-horizontal" @submit.prevent="submit($event.target)">

						<input-form name="content1" text="Titulo 1" :data.sync="content.title1" validate="required"></input-form>
						<input-form name="content2" text="Titulo 2" :data.sync="content.title2" validate="required"></input-form>		

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
				content:{
					title1:'',
					title2:''
				},
				id:4,
				
			}
		},
		
		methods:{
			getContent(){
				this.$parent.inPetition=true;
				axios.get(tools.url("/api/titles")).then((response)=>{
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
	
					var data=tools.params(form,this.content);					

					axios.post(tools.url("/api/titles"),data).then((response)=>{
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