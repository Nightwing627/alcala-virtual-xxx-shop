<template>
    <div class="row">

        <div class="col-md-offset-1 col-md-10">

            <div class="panel panel-primary" data-collapsed="0">

                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="fas fa-shopping-cart"></i> Pedido
                    </div>
                    <div class="panel-options">
                        <a @click="$router.push('/orders/')"><i class="fas fa-times"></i></a>
                    </div>
                </div>

                <div class="panel-body">

                    <div id="tabs" >
                        <ul class="nav nav-tabs">
                            <li :class="activeOrder"><a @click="setActive(1)" href="#1" data-toggle="tab">Información del pedido</a></li>
                            <li :class=" activeCustomer "><a @click="setActive(2)" href="#2" data-toggle="tab">Cliente</a></li>
                            <li :class=" activeDetails "><a @click="setActive(3)" href="#3" data-toggle="tab">Detalle</a></li>
                            <li :class=" activeFactura "><a @click="setActive(4)" href="#2" data-toggle="tab">Datos de facturación</a></li>
                        </ul>

                        <div class="tab-content">
                            <div :class=" 'tab-pane ' + activeOrder" id="1">
                                <div class="row">
                                    <h3 class="text-center">Información del pedido</h3>
                                    <div class="col-md-offset-3 col-md-6">

                                        <table class="table table-striped">
                                            <thead></thead>
                                            <tbody>
                                              <tr>
                                                <th>Id del pedido:</th>
                                                <td scope="row">{{order.id}}</td>
                                              </tr>
                                              <tr>
                                                <th>Fecha y hora:</th>
                                                <td scope="row">{{order.created_at}}</td>
                                              </tr>
                                              <tr>
                                                <th>Recibo:</th>
                                                <td scope="row">
                                                    <button class="btn btn-success btn-sm" @click="mostrarRecibo()">
                                                        <i class="color-white fas fa-clipboard"></i> Ver recibo
                                                    </button>
                                                </td>
                                              </tr>
                                              <tr v-if="cliente.user">
                                                <th>Cliente:</th>
                                                <td scope="row">{{ cliente.user.name }} {{ cliente.user.lastname }}</td>
                                              </tr>
                                              <!-- <tr>
                                                <th scope="row">Forma de pago:</th>
                                                <td>{{order.type_payment}}</td>
                                              </tr> -->
                                              <tr v-if="order.weight">
                                                <th scope="row">Peso:</th>
                                                <td>{{ order.weight }}</td>
                                              </tr>
                                              <tr>
                                                <th scope="row">Metodo de pago:</th>
                                                <td>{{ order.PaymentMethod }}</td>
                                              </tr>
                                              <tr>
                                                <th scope="row">Subtotal:</th>
                                                <td>$ {{ order.subtotal }}</td>
                                              </tr>
                                              <tr>
                                                <th scope="row">Costo de envio:</th>
                                                <td>$ {{ order.shippingCost }}</td>
                                              </tr>
                                              <tr>
                                                <th scope="row">Total:</th>
                                                <td>$ {{ order.total }}</td>
                                              </tr>
                                              <tr>
                                                <th>Estatus:</th>
                                                <td scope="row">
                                                  <select v-model="order.status">
                                                    <option value="pendiente">Pendiente de pago</option>
                                                    <option value="pagado">Pagado</option>
                                                    <option value="entregado">Entregado</option>
                                                    <option value="cancelado">Cancelado</option>
                                                  </select>
                                                </td>
                                              </tr>
                                              <tr>
                                                <th></th>
                                                <td scope="row" style="float: left;">
                                                  <button type="button" class="btn btn-success pull-right" v-on:click="guardar()"><i class="far fa-save"></i> Guardar</button>
                                                </td>
                                              </tr>
                                            </tbody>
                                          </table>
                                    </div>
                                    

                                </div>
                            </div>

                            <div :class=" 'tab-pane ' + activeCustomer" id="2">

                                <div class="row">
                                    <h3 class="text-center">Información del cliente</h3>
                                    <div class="col-md-offset-3 col-md-6">

                                        <table class="table table-striped" v-if="order">
                                            <thead></thead>
                                            <tbody>
                                              <tr v-if="cliente.user">
                                                <th>Nombre:</th>
                                                <td scope="row">{{ cliente.user.name }} {{ cliente.user.lastname }}</td>
                                              </tr>
                                              <tr v-if="cliente.user">
                                                <th scope="row">Teléfono:</th>
                                                <td>{{ cliente.user.phone }}</td>
                                              </tr>
                                              <tr v-if="cliente.user">
                                                <th scope="row">Correo:</th>
                                                <td>{{ cliente.user.email }}</td>
                                              </tr>
                                              <tr v-if="order.street">
                                                <th scope="row">Calle:</th>
                                                <td>{{ order.street }}</td>
                                              </tr>
                                              <tr v-if="order.num_ext">
                                                <th scope="row">Numero exterior:</th>
                                                <td>{{ order.num_ext }}</td>
                                              </tr>
                                              <tr v-if="order.num_int">
                                                <th scope="row">Numero interior:</th>
                                                <td>{{ order.num_int }}</td>
                                              </tr>
                                              <tr v-if="order.postalCode">
                                                <th scope="row">Codigo postal:</th>
                                                <td>{{ order.postalCode }}</td>
                                              </tr>
                                              <tr v-if="order.state_id">
                                                <th scope="row">Estado</th>
                                                <td>{{ order.state.name }}</td>
                                              </tr>
                                              <tr v-if="order.town_id">
                                                <th scope="row">Ciudad:</th>
                                                <td>{{ order.town.name }}</td>
                                              </tr>
                                              <tr v-if="order.neighborhood">
                                                <th scope="row">Colonia:</th>
                                                <td>{{ order.neighborhood }}</td>
                                              </tr>      
                                            </tbody>
                                        </table>
                                    </div>
                                    

                                </div>

                            </div>  

                            <div :class=" 'tab-pane ' + activeDetails" id="3">
                                <div class="row">
                                    <div class="col-md-12">
                                            <br>
                                        <table id="details"></table>
                                    </div>
                                </div>
                            </div>

                            <div :class=" 'tab-pane ' + activeFactura" id="4">

                                <div class="row">
                                  <div class="col-md-12">

                                  <form role="form" class="form-horizontal" @submit.prevent="submit($event.target)" v-if="factura">
                                    <input-form name="cliente" text="Nombre del cliente" type="text" :data.sync="factura.nombre" :disabled="true"></input-form>

                                    <input-form name="rfc" text="RFC" type="text" :data.sync="factura.rfc" :disabled="true"></input-form>

                                    <input-form name="comprobante" text="Tipo de comprobante" type="text" :data.sync="factura.tipo" :disabled="true"></input-form>

                                    <input-form name="cuenta" text="Cuenta con la que realizara el pago" type="text" :data.sync="factura.cuenta" :disabled="true"></input-form>

                                    <input-form name="email" text="Email" type="text" :data.sync="factura.correo" :disabled="true"></input-form>

                                    <input-form name="cliente" text="Dirección" type="text" :data.sync="factura.direccion" :disabled="true"></input-form>

                                    <input-form name="cliente" text="Número exterior" type="number" :data.sync="factura.no_ext" :disabled="true"></input-form>

                                    <input-form name="cliente" text="Número interior" type="number" :data.sync="factura.no_int" :disabled="true"></input-form>

                                    <input-form name="cliente" text="Teléfono" type="text" :data.sync="factura.telefono" :disabled="true"></input-form>

                                    <input-form name="cliente" text="Código Postal" type="text" :data.sync="factura.cp" :disabled="true"></input-form>

                                    <input-form name="cliente" text="Colonia" type="text" :data.sync="factura.colonia" :disabled="true"></input-form>

                                    <input-form name="cliente" text="Ciudad" type="text" :data.sync="factura.town.name" :disabled="true"></input-form>

                                    <input-form name="cliente" text="Estado" type="text" :data.sync="factura.state.name" :disabled="true"></input-form>

                                  </form>
                                  
                                  <p v-else>No se requiere factura.</p>

                                  </div>
                                </div>

                            </div>

                        </div>
                    
                    </div>

                </div>
            </div>
        </div>

    </div>
</template>
<script type="text/javascript">
    export default {
        data(){
            return {
              id:0,
              order: [],
              cliente: [],
              detalles: [],
              active:1,
              factura: []
            }
        },
        computed:{
            activeOrder: function()
            {
                return (this.active == 1) ? 'active' : '';
            },
            activeCustomer: function()
            {
                return (this.active == 2) ? 'active' : '';
            },
            activeDetails: function()
            {
                return (this.active == 3) ? 'active' : '';
            },
            activeFactura: function()
            {
                return (this.active == 4) ? 'active' : '';
            }

        },
        methods:{
            mostrarRecibo(){
                window.open(this.order.pdf,"ventana1","Recibo de su pedido,height=300,scrollbars=NO");
            },
            
            getOrder()
            {
                this.$parent.inPetition = true;
                axios.get(tools.url("/api/orders/"+ this.id))
                .then((response)=>{
                    this.order = response.data.order;
                    this.cliente = response.data.customer;
                    this.detalles = response.data.details;
                    this.factura = response.data.factura;
                    this.$parent.inPetition = false;
                }).catch((error)=>{
                    this.$parent.handleErrors(error);
                    this.$parent.inPetition = false;
                }).finally(()=>{
                    this.mounthTableDetails();
                });
            },

            setActive(val)
            {
                this.active = val;
            },
            
            //Cargar la tabla de detalles
            mounthTableDetails()
            {
                jQuery('#details').bootstrapTable({
                    columns: [
                        {
                            field:"check",
                            checkbox:true,
                            align: 'center'
                        },
                        {
                            field: 'product.image',
                            title: '',
                            sortable:true,
                            switchable:true,
                            align: 'center'
                        },
                        {
                            field: 'product.name',
                            title: 'Nombre del producto',
                            sortable: true,
                            switchable: true,
                            align: 'center'
                        },
                        {
                            field: 'product.sku',
                            title: 'SKU',
                            sortable: true,
                            switchable: true,
                            align: 'center'
                        },
                        {
                            field: 'quantity',
                            title: 'Cantidad',
                            sortable: true,
                            switchable: true,
                            align: 'center'
                        },
                        {
                            field: 'price',
                            title: 'Precio',
                            sortable: true,
                            switchable: true,
                            align: 'center'
                        }
                        
                    ],
                    //url: tools.url("/api/proveedor/" + this.id + "/categories"),
                    //data: this.categories,
                    //Boton de refrescar
                    showRefresh:true,
                    //Define si tienen detalles cada fila       
                    // detailView:true,
                    // detailFormatter:"detailFormatter",
                    
                });
                jQuery('#details').bootstrapTable('removeAll');
                jQuery('#details').bootstrapTable('append',this.detalles);
            },

            guardar()
            {
              this.$parent.inPetition = true;
              axios.post(tools.url("/api/order/"+ this.id),{status:this.order.status}).then((response)=>{
                  this.$parent.showMessage(response.data.msg,"success");
                }).catch((error)=>{
                    this.$parent.handleErrors(error);
                }).finally(()=>{
                    this.$parent.inPetition = false;
                });
            }
        },

        mounted(){
            if(this.$route.params.id)
            {
                this.id = this.$route.params.id;
                this.getOrder();
            }
            
        }
    }
</script>
<style type="text/css">
    th{
        text-align: right;
    }
    td{
        text-align: left;
    }
</style>
