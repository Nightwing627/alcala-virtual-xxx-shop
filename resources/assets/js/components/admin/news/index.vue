<template>
  <div>
		<div class="row">
			<div class="col-md-12">
				<div id="toolbar">
            <router-link to="/news/edit"><button class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Nuevo</button></router-link>
			      <button class="btn btn-danger btn-sm" @click="deleteNews()"><i class="fa fa-trash"></i> Borrar</button>
			    </div>
				<table id="news"></table>
			</div>
		</div>
	</div>
</template>
<script type="text/javascript">
  export default {
  data(){
    return {
      news:[],
    }
  },
  methods:{
    mounthTable(){
      jQuery('#news').bootstrapTable({
        columns: [
          {
            field:"check",
            checkbox:true,
            align: 'center',
          },
          {
            field: 'image',
            title: 'Imagen',
            sortable:false,
            width:"52px",
          },          
          {
            field: 'title',
            title: 'Titulo',
            sortable:true,
            switchable:true,
          },
          {
            field: 'created_at',
            title: 'Fecha de registro',
            sortable:true,
            switchable:true,
          },
          {
            field: 'updated_at',
            title: 'Fecha de actualización',
            sortable:true,
            switchable:true,
          }

          
        ],
        showRefresh:true,
      });

      jQuery('#news').on('refresh.bs.table',()=>{
        this.getNews();
      });

      jQuery('#news').on('click-row.bs.table',(row,data)=>{
        this.$router.push('/news/edit/'+data.id);
      });

      this.getNews();

    },
    getNews(){
      this.$parent.inPetition=true;
      axios.get(tools.url("/api/news")).then((response)=>{
          this.news = response.data;
          jQuery('#news').bootstrapTable('removeAll');
          jQuery('#news').bootstrapTable('append',this.news);
          this.$parent.inPetition=false;
        }).catch((error)=>{
            this.$parent.handleErrors(error);
            this.$parent.inPetition=false;
        });
    },

    deleteNews:function(){
      var rows=jQuery('#news').bootstrapTable('getSelections');
      if(rows.length==0){
        return false;
      }
      alertify.confirm("Alerta!","¿Seguro que deseas borrar "+rows.length+" registros?",()=>{
        this.$parent.inPetition=true;
        var params={};
        params.ids=jQuery.map(rows,(row)=>{
          return row.id;
        });

        axios.delete(tools.url('/api/news'),{data:params})
        .then((response)=>{
          this.$parent.showMessage(response.data.msg,"success");
          this.getNews();
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
