<template>
  <div>
		<div class="row">
			<div class="col-md-12">
				<div id="toolbar">
			        <router-link to="/coupon/edit">
			        	<button class="btn btn-success btn-sm">
				            <i class="fa fa-plus"></i> Nuevo
				        </button>
			        </router-link>
			        <button class="btn btn-danger btn-sm" @click="deleteCoupons()">
			            <i class="fa fa-trash"></i> Borrar
			        </button>
			    </div>
				<table id="coupons"></table>
			</div>
		</div>
	</div>
</template>
<script type="text/javascript">
  export default {
    data(){
      return{
        coupons: [],
      }
    },
    methods: {
      mounthTable(){
        jQuery('#coupons').bootstrapTable({
          columns: [
            {
              field:"check",
              checkbox:true,
              align: 'center',
            },
            {
              field: 'nombre',
              title: 'Nombre',
              sortable:true,
              switchable:true,
            },
            {
              field: 'codigo',
              title: 'Codigo',
              sortable:true,
              switchable:true,
            },
            {
              field: 'stock',
              title: 'Usos restantes',
              sortable:true,
              switchable:true,
            },
            {
              field: 'porcentaje',
              title: 'Descuento',
              sortable:true,
              switchable:true,
            },
            {
              field: 'fechaInicio',
              title: 'Desde',
              sortable:true,
              switchable:true,
            },
            {
              field: 'fechaFin',
              title: 'Hasta',
              sortable:true,
              switchable:true,
            }
          ],
          showRefresh:true,
        });
        jQuery('#coupons').on('refresh.bs.table',()=>{
          this.getCoupons();
        });
        jQuery('#coupons').on('click-row.bs.table',(e, row, data, $element)=>{
          if($element=='boton'){
            this.$router.push('/coupon/'+row.id+'/historial');
          }else{
            this.$router.push('/coupon/edit/'+row.id);
          }
        });
        this.getCoupons();
      },
      getCoupons(){
        this.$parent.inPetition=true;
        axios.get(tools.url("/api/coupons")).then((response)=>{
            this.coupons=response.data;
            jQuery('#coupons').bootstrapTable('removeAll');
            jQuery('#coupons').bootstrapTable('append',this.coupons);
            this.$parent.inPetition=false;
        }).catch((error)=>{
          this.$parent.handleErrors(error);
          this.$parent.inPetition=false;
        });
      },
      deleteCoupons:function(){
        var rows=jQuery('#coupons').bootstrapTable('getAllSelections');
        if(rows.length==0){
          return false;
        }
        alertify.confirm("Alerta!","¿Seguro que deseas borrar "+rows.length+" registros?",()=>{
          this.$parent.inPetition=true;
          var params={};
          params.ids=jQuery.map(rows,(row)=>{
            return row.id;
          });

          axios.delete(tools.url('/api/coupons'),{data:params}).then((response)=>{
            this.$parent.showMessage(response.data.msg,"success");
            this.getCoupons();
            this.$parent.inPetition=false;
          })
          .catch((error)=>{
            this.$parent.handleErrors(error);
            this.$parent.inPetition=false;
          });
         },()=>{
        });
      }
    },
    mounted(){
      this.mounthTable();
    }
  }
</script>
