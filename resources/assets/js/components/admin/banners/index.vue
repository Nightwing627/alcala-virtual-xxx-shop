<template>
  <div>
		<div class="row">
			<div class="col-md-12">
				<div id="toolbar">
			        <router-link to="/banners/edit">
			        	<button class="btn btn-success btn-sm">
				            <i class="fa fa-plus"></i> Nuevo
				        </button>
			        </router-link>
			        <button class="btn btn-danger btn-sm" @click="deleteBanners()">
			            <i class="fa fa-trash"></i> Borrar
			        </button>
			    </div>
				<table id="banners"></table>
			</div>
		</div>
	</div>
</template>
<script type="text/javascript">
  export default {
  data(){
    return {
      banners:[],
    }
  },
  methods:{
    mounthTable(){
      jQuery('#banners').bootstrapTable({
        columns: [
          {
            field:"check",
            checkbox:true,
            align: 'center',
          },          
          {
            field: 'imagen',
            title: ' ',
            sortable:false,
            width:"52px",
          },
          {
            field: 'name',
            title: 'Nombre',
            sortable:true,
            switchable:true,
          },
          {
            field: 'device',
            title: 'Dispositivo',
            sortable:true,
            switchable:true,
          },
          {
            field: 'section',
            title: 'Sección',
            sortable:true,
            switchable:true,
          },
          {
            field: 'position',
            title: 'Posicion',
            sortable:true,
            switchable:true,
          },
          {
            field: 'status',
            title: 'Activo',
            sortable:true,
            switchable:true,
          }

          
        ],
        showRefresh:true,
      });

      jQuery('#banners').on('refresh.bs.table',()=>{
        this.getBanners();
      });

      jQuery('#banners').on('click-row.bs.table',(row,data)=>{
        this.$router.push('/banners/edit/'+data.id);
      });

      this.getBanners();

    },
    getBanners(){
      this.$parent.inPetition=true;
      axios.get(tools.url("/api/banners")).then((response)=>{
          this.banners=response.data;
          jQuery('#banners').bootstrapTable('removeAll');
          jQuery('#banners').bootstrapTable('append',this.banners);
          this.$parent.inPetition=false;
        }).catch((error)=>{
            this.$parent.handleErrors(error);
            this.$parent.inPetition=false;
        });
    },
    deleteBanners:function(){
      var rows=jQuery('#banners').bootstrapTable('getSelections');
      if(rows.length==0){
        return false;
      }
      alertify.confirm("Alerta!","¿Seguro que deseas borrar "+rows.length+" registros?",()=>{
        this.$parent.inPetition=true;
        var params={};
        params.ids=jQuery.map(rows,(row)=>{
          return row.id;
        });

        axios.delete(tools.url('/api/banners'),{data:params})
        .then((response)=>{
          this.$parent.showMessage(response.data.msg,"success");
          this.getBanners();
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
