<template>
	<div>
		<div class="row">
			<div class="col-md-12">
				<div id="toolbar">
			        <router-link to="/customers/edit">
			        	<button class="btn btn-success btn-sm">
				            <i class="fa fa-plus"></i> Nuevo
				        </button>
			        </router-link>
			        <button class="btn btn-danger btn-sm" @click="deleteRows()">
			            <i class="fa fa-trash"></i> Borrar
			        </button>
			    </div>
				<table id="table"></table>
			</div>
		</div>
	</div>
</template>
<script type="text/javascript">
	export default {
		data(){
			return {
				customers:[],
			}
		},
		methods:{
			mounthTable(){
				jQuery('#table').bootstrapTable({
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
							
						},
						{
					        field: 'name',
					        title: 'Nombre',
					        sortable:true,
							switchable:true,
							
						},
						{
					        field: 'phone',
					        title: 'Telefono',
					        sortable:true,
							switchable:true,
							
					    },  
					    {
					    	field: 'created_at',
					    	title: 'Registrado',
					    }
					],
				    // data: this.users,
					//Boton de refrescar
					showRefresh:true,
		            //Define si tienen detalles cada fila       
		            // detailView:true,
		            // detailFormatter:"detailFormatter",
            		
				});

				jQuery('#table').on('refresh.bs.table',()=>{
					this.getRows();
				});

				jQuery('#table').on('click-row.bs.table',(row,data)=>{
					this.$router.push('/customers/edit/'+data.id);
					// console.log(data);
				});

				this.getRows();

			},

			getRows(){
				this.$parent.inPetition=true;
				axios.get(tools.url("/api/customers")).then((response)=>{
					this.customers = response.data;
			    	jQuery('#table').bootstrapTable('removeAll');
			    	jQuery('#table').bootstrapTable('append',this.customers);
			    	this.$parent.inPetition=false;
			    }).catch((error)=>{
			        this.$parent.handleErrors(error);
			        this.$parent.inPetition=false;
			    });
			},

			deleteRows:function(){
				var rows=jQuery('#table').bootstrapTable('getSelections');
				if(rows.length==0){
					return false;
				}
				alertify.confirm("Alerta!","¿Seguro que deseas borrar "+rows.length+" registros?",()=>{
					this.$parent.inPetition=true;
					var params={};
					params.ids=jQuery.map(rows,(row)=>{
						return row.id;
					});
					
					axios.delete(tools.url('/api/customers'),{data:params})
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