<template>
	<div class="row">
		<div class="col-md-offset-1 col-md-10">
			
			<div class="panel panel-primary" data-collapsed="0">
			
				<div class="panel-heading">
					<div class="panel-title">
						<h3><i class="fa fa-angle-right"></i> Importar</h3>
					</div>
					
				</div>
				
				<div class="panel-body">
                    <div class="alert alert-info" role="alert">
                        <h4 class="alert-heading">AVISO!</h4>
                        <p class="mb-0">Solo se permite subir archivos con extensión: xls, xlsx, csv.</p>
                    </div>

					<form role="form" class="form-horizontal" @submit.prevent="submit($event.target)">

						<div class="form-group">
                            <label class="col-sm-3 control-label">Archivo</label>
                            <div class="col-sm-7 text-center">
                                <input type="file" name="file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                            </div>
                        </div>	
							

						<div class="form-group">
							<div class="col-sm-12">
								<!-- <a href="https://internetizante.com/queen-sense/Ejemplo-importar.xlsx" class="btn btn-primary"><i class="fa fa-download"></i> Descargar Ejemplo</a> -->
								<button type="button" class="btn btn-default pull-right" @click="$router.push('/products/')">Cancelar</button>
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
				body: null,
			}
		},
		
		methods:{
			submit(form){			
				this.$parent.inPetition=true;
				this.$parent.validateAll(()=>{
					var data = tools.params(form);					
					axios.post(tools.url("/api/importProducts"), data).then((response)=>{
				    	this.$parent.showMessage(response.data.msg,"success");
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
		}
	}
</script>