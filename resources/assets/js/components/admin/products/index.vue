<template>
  <div>
		<div class="row">
			<div class="col-md-12">
				<div id="toolbar">
			        <router-link to="/products/edit">
			        	<button class="btn btn-success btn-sm">
				            <i class="fa fa-plus"></i> Nuevo
				        </button>
			        </router-link>
			        <button v-if="isAdmin" class="btn btn-danger btn-sm" @click="deleteRows()">
			            <i class="fa fa-trash"></i> Borrar
			        </button>
              <router-link to="/products/import">
              <button class="btn btn-success btn-sm">
                  <i class="fa fa-file"></i> Importar
              </button>
            </router-link>
            <a class="btn btn-primary btn-sm" href="./api/products/export" target="_blank" v-if="isAdmin"><i class="fa fa-file"></i> Exportar</a>
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
      productos:[],
      isAdmin: false
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
            title: 'Foto',
            sortable:false,
            width:"52px",
          },          
          {
            field: 'sku',
            title: 'SKU',
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
            field: 'category.name',
            title: 'Categoria',
            sortable:true,
            switchable:true,
          },
          {
            field: 'subcategory.name',
            title: 'Subcategoria',
            sortable:true,
            switchable:true,
          },
          {
            field: 'created_at',
            title: 'Fecha de creación',
            sortable:true,
            switchable:true,
          }
        ],
        showRefresh:true,
        
      });

      jQuery('#table').on('refresh.bs.table',()=>{
        this.getContent();
      });

      jQuery('#table').on('click-row.bs.table',(row,data)=>{
        this.$router.push('/products/edit/'+data.id);
      });

      this.getContent();

    },

    getContent(){
      this.$parent.inPetition=true;
      axios.get(tools.url("/api/products")).then((response)=>{
          this.productos = response.data;
          jQuery('#table').bootstrapTable('removeAll');
          jQuery('#table').bootstrapTable('append',this.productos);
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

        axios.delete(tools.url('/api/products'),{data:params})
        .then((response)=>{
          this.$parent.showMessage(response.data.msg,"success");
          this.getContent();
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
          
          this.isAdmin = this.$root.user.roles.find(function(value, index) {
            if(value.name == 'administrador'){
              return true;
            }
          });
      }
  }
</script>
