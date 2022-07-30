<template>
  <div>
		<div class="row">
			<div class="col-md-12">
				<div id="toolbar">
			        <router-link to="/stores/edit">
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
      content:[],
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
            field: 'id',
            title: '#',
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
        this.$router.push('/stores/edit/'+data.id);
      });

      this.getContent();

    },

    getContent(){
      this.$parent.inPetition=true;
      axios.get(tools.url("/api/stores")).then((response)=>{
          this.content = response.data;
          jQuery('#table').bootstrapTable('removeAll');
          jQuery('#table').bootstrapTable('append',this.content);
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

        axios.delete(tools.url('/api/stores'),{data:params})
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
      }
  }
</script>
