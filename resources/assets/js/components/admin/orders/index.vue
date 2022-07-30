<template>
    <div>
        <div class="row">
            <h3 class="col-sm-12 control-label text-center">Pedidos</h3>
            <div class="col-md-12">
                <div class="panel panel-primary text-center" data-collapsed="0">
                  <div class="panel-body">
                    <div class="col-md-3">
                        <div class="card pink">
                          <h4 class="title">Total Ventas Día:</h4>
                          <i class="zmdi zmdi-upload"></i>
                          <h4 class="value">$ {{ Intl.NumberFormat("en-US", { minimumFractionDigits: 2 }).format(totals.totalToDay) }}</h4>
                          <div class="stat"></div>
                        </div>
                       <strong> </strong>
                    </div>
                    <div class="col-md-3">
                      <div class="card pink">
                          <h4 class="title">Total Pedidos Día:</h4>
                          <i class="zmdi zmdi-upload"></i>
                          <h4 class="value">$ {{ Intl.NumberFormat("en-US", { minimumFractionDigits: 2 }).format(totals.totalc) }}</h4>
                          <div class="stat"></div>
                        </div>
                       <strong> </strong>
                    </div>
                    <div class="col-md-3">
                      <div class="card black">
                          <h4 class="title">Total Ventas Mes: </h4>
                          <i class="zmdi zmdi-upload"></i>
                          <h4 class="value">$ {{ Intl.NumberFormat("en-US", { minimumFractionDigits: 2 }).format(totals.totalMonth) }}</h4>
                          <div class="stat"></div>
                        </div>
                       <strong> </strong>
                    </div>
                    <div class="col-md-3">
                      <div class="card black">
                          <h4 class="title">Total Pedidos Mes:</h4>
                          <i class="zmdi zmdi-upload"></i>
                          <h4 class="value">$ {{ Intl.NumberFormat("en-US", { minimumFractionDigits: 2 }).format(totals.total) }}</h4>
                          <div class="stat"></div>
                        </div>
                       <strong> </strong>
                    </div>
                    
                  </div>
                </div>
              </div>

            <div class="col-md-12">
                <div id="toolbar">
                    
                    <!-- <button class="btn btn-danger btn-sm" @click="cancelarPedidos()">
                        <i class="fa fa-trash"></i> Cancelar pedidos
                    </button>

                    <button class="btn btn-success btn-sm" @click="pagarPedidos()">
                        <i class="fa fa-check"></i> Pagar pedidos
                    </button> -->
                </div>
                <table id="pedidos"></table>
            </div>
        </div>
    </div>
</template>
<script type="text/javascript">
    export default {
        data(){
            return {
                orders:[],

                totals:{
                    totalToDay: 0,
                    totalMonth: 0,
                    total: 0,
                    totalc: 0
                }
            }
        },
        methods:{
            mounthTable(){
                jQuery('#pedidos').bootstrapTable({
                    columns: [
                        {
                            field:"check",
                            checkbox:true,
                            align: 'center'
                        },
                        {
                            field: 'id',
                            title: 'Id Pedido',
                            sortable:true,
                            switchable:true,
                            align: 'center'
                        },
                        {
                            field: 'created_at',
                            title: 'Fecha de creación',
                            sortable:true,
                            switchable:true,
                            align: 'center'
                        },                    
                        {
                            field: 'status',
                            title: 'Estatus',
                            sortable:true,
                            switchable:true,
                            align: 'center'
                        },
                        {
                            field: 'PaymentMethod',
                            title: 'Metodo de pago',
                            sortable:true,
                            switchable:true,
                            align: 'center'
                        },
                        {
                            field: 'customer.user.name',
                            title: 'Cliente',
                            sortable:true,
                            align: 'center'
                        },

                        {
                            field: 'customer.user.email',
                            title: 'Email del cliente',
                            sortable:true,
                            align: 'center'
                        },

                        {
                            field: 'subtotal',
                            title: 'Subtotal',
                            sortable:true,
                            switchable:true,
                            align: 'center'
                        },
                        {
                            field: 'total',
                            title: 'Total',
                            sortable:true,
                            switchable:true,
                            align: 'center'
                        },
                        
                    ],
                    //Boton de refrescar
                    showRefresh:true,

                });

                jQuery('#pedidos').on('refresh.bs.table',()=>{
                    this.getContent();
                });

                jQuery('#pedidos').on('click-row.bs.table',(row,data)=>{
                    this.$router.push('/orders/detail/'+data.id);
                });

                this.getContent();

            },

            getContent(){
                this.$parent.inPetition = true;
                axios.get(tools.url("/api/orders")).then((response)=>{
                    this.totals = response.data.totals;
                    this.orders = response.data.orders;

                    jQuery('#pedidos').bootstrapTable('removeAll');
                    jQuery('#pedidos').bootstrapTable('append',response.data.orders);
                    this.$parent.inPetition = false;
                }).catch((error)=>{
                    this.$parent.handleErrors(error);
                    this.$parent.inPetition=false;
                });
            },

        },
        mounted() {
            this.mounthTable();
        }
    }
</script>
