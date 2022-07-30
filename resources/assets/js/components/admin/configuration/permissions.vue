<template>
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			
			<div class="panel panel-primary" data-collapsed="0">
			
				<div class="panel-heading">
					<div class="panel-title">
						<i class="fa fa-user"></i> Permisos
					</div>
					<div class="panel-options">
						<a @click="$router.push('/roles/')"><i class="fas fa-times"></i></a>
					</div>
				</div>
				
				<div class="panel-body">
					<form role="form" class="form-horizontal" @submit.prevent="savePermission($event.target)">
						<input-form name="nombre" text="Nombre" :data.sync="role.name" validate="alpha_spaces|required|min:5"></input-form>
						<div class="row">
							<div class="col-md-3 control-label">
								<b>Permisos</b>
							</div>
						</div>
						<!-- <switch-form v-for="perm in permissions" name="perms" :text="perm.name" :value="perm.name" :data.sync="role.permissions" :key="perm.id"></switch-form> -->

						<checkbox-form v-for="perm in permissions" name="perms2" :text="perm.name" :value="perm.name" :data.sync="role.permissions" :key="perm.id"></checkbox-form>

						<div class="form-group">
							<div class="col-sm-12">
								<button type="button" class="btn btn-danger" @click="deleteRole" v-show="$route.params.id"><i class="fa fa-trash"></i> Borrar</button>
								<button type="submit" class="btn btn-success pull-right"><i class="far fa-save"></i> Guardar</button> 
								<button type="button" class="btn btn-default pull-right" @click="$router.push('/roles/')">Cancelar</button>			
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
				permissions:{},
				id:"",
				role:{},
			}
		},
		methods:{
			getPermissions:function(){
				this.$parent.inPetition=true;
				axios.get(tools.url("/api/permissions"))
				.then((response)=>{
					this.permissions=response.data;
					this.$parent.inPetition=false;
				})
				.catch((error)=>{
					this.$parent.handleErrors(error);
					this.$parent.inPetition=false;
				});
			},
			savePermission:function(e){
				this.$parent.inPetition=true;
				this.$parent.validateAll(()=>{
					axios.post(tools.url("/api/role/"+this.id),this.role)
					.then((response)=>{
						this.$parent.showMessage(response.data.msg,"success");
						this.$parent.inPetition=false;
					})
					.catch((error)=>{
						this.$parent.handleErrors(error);
						this.$parent.inPetition=false;
					});
				},()=>{
					this.$parent.inPetition=false;
				});
				
				
			},
			deleteRole:function(){
				alertify.confirm("¿Seguro que deseas borrar este rol?",()=>{
					this.$parent.inPetition=true;
					axios.delete(tools.url("/api/role/"+this.id))
					.then((response)=>{
						this.$parent.showMessage(response.data.msg,"warning");
						this.$router.push('/roles/');
					})
					.catch((error)=>{
						this.$parent.handleErrors(error);
						this.$parent.inPetition=false;
					});
				});
			},
			getRole:function(){
				this.$parent.inPetition=true;
				axios.get(tools.url("/api/role/"+this.id))
				.then((response)=>{
					var role=response.data;
					role.permissions=jQuery.map(role.permissions,(row)=>{
						return row.name;
					});
					this.role=role;
					this.$parent.inPetition=false;
				})
				.catch((error)=>{
					this.$parent.handleErrors(error);
					this.$parent.inPetition=false;
				});
			},
		},
		mounted(){
			this.id=this.$route.params.id;
			this.getRole();
			
			this.getPermissions();
		},
	}
</script>