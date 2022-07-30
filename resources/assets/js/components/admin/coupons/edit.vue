<template>
	<div class="row">
		<div class="col-md-offset-1 col-md-10">
			<div class="panel panel-primary" data-collapsed="0">
				<div class="panel-heading">
					<div class="panel-title">
						<i class="fas fa-percentage"></i> Cupones
					</div>
					<div class="panel-options">
						<a @click="$router.push('/coupons/')"><i class="fas fa-times"></i></a>
					</div>
				</div>
				<div class="panel-body">
					<form role="form" class="form-horizontal" @submit.prevent="newCoupon($event.target)">

						<input-form name="nombre" text="Nombre" :data.sync="coupon.nombre" validate="required"></input-form>
                        <input-form name="stock" type="number" text="stock" :data.sync="coupon.stock" validate="required"></input-form>
                        <input-form name="codigo" text="codigo" :data.sync="coupon.codigo" validate="required"></input-form>
                        <!--<b-form-input type="number" min="0.01" max="1" name="porcentaje" text="Porcentaje" :data.sync="coupon.porcentaje" validate="required"></b-form-input>-->
                        <!--<input-form name="porcentaje" text="porcentaje" :data.sync="coupon.porcentaje" validate="required"></input-form>-->

                        <div class="form-group">
                        	<label for="field-1" class="col-sm-3 control-label">Porcentaje<span style="display: none;">*</span>:</label>
                        	<div class="col-sm-7"><input v-model="coupon.porcentaje" type="number" name="porcentaje" min="1" max="100" step="1" placeholder="" class="form-control" aria-required="true" aria-invalid="false">
                        		<small class="has-error" style="display: none;"></small>
                        	</div>
                        </div>

						<input-form type="date" name="desde" text="Desde" :data.sync="coupon.fechaInicio" validate="required"></input-form>
						<input-form type="date" name="hasta" text="Hasta" :data.sync="coupon.fechaFin" validate="required"></input-form>

						<!-- <div class="form-group">
							<label class="col-sm-3 control-label">Categoria (Opcional):</label>
							<div class="col-sm-7">
								<v-select v-model="coupon.categoria_id" :options="categorias" label="nombre" index="id" />
							</div>
						</div> -->

            <div class="form-group">
							<div class="col-sm-12">
								<button type="button" class="btn btn-danger" @click="deleteCoupon" v-show="$route.params.id"><i class="fa fa-trash"></i> Borrar</button>
								<button type="submit" class="btn btn-success pull-right"><i class="far fa-save"></i> Guardar</button>
								<button type="button" class="btn btn-default pull-right" @click="$router.push('/coupons/')">Cancelar</button>
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
				coupon:{
                    nombre: '',
                    stock: '',
                    codigo: '',
                    porcentaje: '',
					fechaInicio:'',
					fechaFin:'',
					categoria_id: null
				},
				id:"",
				categorias: []
			}
		},
		methods:{
			getCoupons(){
				this.$parent.inPetition=true;
				axios.get(tools.url("/api/coupons/"+this.id)).then((response)=>{
			    	this.coupon=response.data;

			    	this.$parent.inPetition=false;
			    }).catch((error)=>{
			    	this.$parent.handleErrors(error);
			       this.$parent.inPetition=false;
			    });
			},
			
			newCoupon(form){
				this.$parent.inPetition=true;
				this.$parent.validateAll(()=>{
					var data=tools.params(form,this.coupon);
					if(this.$route.params.id){
						axios.post(tools.url("/api/coupons/"+this.id),data).then((response)=>{
					    	this.getCoupons();
					    	this.$parent.showMessage("Cupon "+this.coupon.nombre+" modificado correctamente!","success");
					    	this.$parent.inPetition=false;
					    }).catch((error)=>{
					    	this.$parent.handleErrors(error);
					       this.$parent.inPetition=false;
					    });
					}
					else{
						axios.post(tools.url("/api/coupons"),data).then((response)=>{
							var coupon=response.data;
					    	this.$parent.showMessage("Cupon "+coupon.nombre+" agregado correctamente!","success");
					    	this.$router.push('/coupon/edit/'+coupon.id);
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

      deleteCoupon:function(){
        alertify.confirm("Alerta!","¿Seguro que deseas borrar este Cupon?",()=>{
          this.$parent.inPetition=true;
          axios.delete(tools.url("/api/coupons/"+this.id))
          .then((response)=>{
          this.$parent.showMessage(response.data.msg,"success");
          this.$router.push("/coupons/");
          this.$parent.inPetition=false;
          })
          .catch((error)=>{
          this.$parent.handleErrors(error);
          this.$parent.inPetition=false;
          });
        },()=>{
			     });
			},
		},

		mounted(){
			if(this.$route.params.id){
				this.id=this.$route.params.id;
          		this.getCoupons();
			}
		}
	}
</script>
