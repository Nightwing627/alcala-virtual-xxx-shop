<template>
  <div>
		<div class="row">
			<div class="col-md-12">
				<div id="toolbar">
			        <!-- <router-link to="/categorias/edit">
			        	<button class="btn btn-success btn-sm">
				            <i class="fa fa-plus"></i> Nuevo
				        </button>
			        </router-link>
			        <button class="btn btn-danger btn-sm" @click="deleteRows()">
			            <i class="fa fa-trash"></i> Borrar
			        </button> -->
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
            field: 'email',
            title: 'Correo electrónico',
            sortable:true,
            switchable:true,
          },
          {
            field: 'phone',
            title: 'Teléfono',
            sortable:true,
            switchable:true,
          },
          {
            field: 'message',
            title: 'Teléfono',
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

      // jQuery('#table').on('click-row.bs.table',(row,data)=>{
      //   this.$router.push('/categorias/edit/'+data.id);
      // });

      this.getContent();

    },

    getContent(){
      this.$parent.inPetition=true;
      axios.get(tools.url("/api/contact")).then((response)=>{
          this.content = response.data;
          jQuery('#table').bootstrapTable('removeAll');
          jQuery('#table').bootstrapTable('append',this.content);
          this.$parent.inPetition=false;
        }).catch((error)=>{
            this.$parent.handleErrors(error);
            this.$parent.inPetition=false;
        });
    }
  },

  mounted() {
    this.mounthTable();
  }
  }
</script>
