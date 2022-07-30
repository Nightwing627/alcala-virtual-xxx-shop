<template>
	<div>
		<div class="row">
			<div class="col-md-12">
				<div id="toolbar">
			        <router-link to="/users/edit">
			        	<button class="btn btn-success btn-sm">
				            <i class="fa fa-plus"></i> Nuevo
				        </button>
			        </router-link>
			        <button class="btn btn-danger btn-sm" @click="deleteUsers()">
			            <i class="fa fa-trash"></i> Borrar
			        </button>
			    </div>
				<table id="users"></table>
			</div>
		</div>
	</div>
</template>
<script type="text/javascript">
	export default {
		data(){
			return {
				users:{},
			}
		},
		methods:{
			mounthTable(){
				jQuery('#users').bootstrapTable({
					columns: [
						{
							field:"check",
							checkbox:true,
							align: 'center',
						},
						{
					        field: 'image',
					        title: ' ',
					        sortable:false,
							
							width:"52px",
					    },
						{
					        field: 'email',
					        title: 'Email',
					        sortable:true,
							switchable:true,
							
					    }, {
					        field: 'name',
					        title: 'Nombres',
					        sortable:true,
							switchable:true,
							
					    }, {
					        field: 'celphone',
					        title: 'Celular',
					        sortable:true,
							switchable:true,
							
					    },
					    {
					    	field: 'types',
					    	title: 'Roles',
					    },
					    {
					    	field: 'access',
					    	title: 'Acceso',
					    }
					],
				    // data: this.users,
					//Boton de refrescar
					showRefresh:true,
		            //Define si tienen detalles cada fila       
		            // detailView:true,
		            // detailFormatter:"detailFormatter",
            		
				});

				jQuery('#users').on('refresh.bs.table',()=>{
					this.getUsers();
				});

				jQuery('#users').on('click-row.bs.table',(row,data)=>{
					this.$router.push('/users/edit/'+data.id);
					// console.log(data);
				});

				this.getUsers();

			},
			getUsers(){
				this.$parent.inPetition=true;
				axios.get(tools.url("/api/users")).then((response)=>{
			    	this.users=response.data;
			    	this.users.forEach((v,k)=>{
			    		this.users[k].types=v.types.join();
			    	});
			    	jQuery('#users').bootstrapTable('removeAll');
			    	jQuery('#users').bootstrapTable('append',this.users);
			    	this.$parent.inPetition=false;
			    }).catch((error)=>{
			        this.$parent.handleErrors(error);
			        this.$parent.inPetition=false;
			    });
			},
			deleteUsers:function(){
				var rows=jQuery('#users').bootstrapTable('getSelections');
				if(rows.length==0){
					return false;
				}
				alertify.confirm("Alerta!","¿Seguro que deseas borrar "+rows.length+" registros?",()=>{
					this.$parent.inPetition=true;
					var params={};
					params.ids=jQuery.map(rows,(row)=>{
						return row.id;
					});
					
					axios.delete(tools.url('/api/users'),{data:params})
					.then((response)=>{
						this.$parent.showMessage(response.data.msg,"success");
						this.getUsers();
						this.$parent.inPetition=false;
					})
					.catch((error)=>{
						this.$parent.handleErrors(error);
				        this.$parent.inPetition=false;
					});

				},
				()=>{
					
				});

				
			}
		},
        mounted() {
            this.mounthTable();
        }
    }
</script>