<template lang="html">
  <div id="cart-page" class="d-flex account-page">
    <div class="container main-box">

      <div class="row">
        <div class="col-12 px-2">
          <h1 class="mb-3 page-title">Mi carrito</h1>
        </div>

        <div class="col-lg px-2 col-menu">
          <div class="white-box">
            <div class="box-menu py-2">
              <!-- <p class="item">
                <router-link class="btn-menu" to="/mis-favoritos"><i class="fas fa-heart"></i> Mis favoritos</router-link>
              </p> -->
              <p class="item">
                <router-link class="btn-menu" to="/cart"><i class="fas fa-shopping-cart"></i> Mi carrito</router-link>
              </p>
              <p class="item">
                <router-link class="btn-menu" to="/historial-de-compras"><i class="fas fa-history"></i> Historial de compras</router-link>
              </p>
            </div>
          </div>
        </div>

        <div class="col-lg px-2 col-cart-data">

          <!-- <div class="white-box"> -->
          <b-form class="white-box" @submit="">

            <!-- Paso 1 (Lista de productos agregados a carrito) -->
            <div class="col-12 pt-3 product-list-table" v-if="$route.params.step !== 'envio' && $route.params.step !== 'pago'">
              <div class="col-12 px-0">
                <h5>Productos agregados al carrito</h5>

                <h6 class="mt-4 pb-4 f-w-400 text-warning" v-if="!form.products.length"><i class="fas fa-shopping-basket"></i> Ningun producto ha sido agregado al carrito</h6>
              </div>

              <div class="row row-products" v-for="(product, index) in form.products">
                <div class="col col-image">
                  <img :src="product.imageUrl">
                </div>

                <div class="col col-info">
                  <h5 class="txt-name">
                    <router-link target="_blank" :to="'/producto/'+product.id">{{ product.name }}</router-link>
                  </h5>

                  <!-- <div class="row mx-0 align-items-center">
                    <div class="d-flex">
                      <h6 class="txt-sm text-muted"></h6>
                    </div>
                    <div class="d-flex">
                      <div class="box-color-opt opt-sm">
                        <a class="color" title="Color x" v-bind:style="{ backgroundColor: '#e63003' }"></a>
                      </div>
                    </div>
                  </div> -->
                  <hr class="mt-0 mb-1" />

                  <router-link class="link-sm text-muted" :to="'/producto/'+product.id"><i class="fas fa-external-link-alt"></i> Ver producto</router-link> <span class="mx-2">|</span> <a class="link-sm text-danger" @click="removeCart(index)"><i class="far fa-trash-alt"></i> Quitar</a>
                </div>

                <div class="col col-price">
                  <p>$ {{ Intl.NumberFormat("en-US", { minimumFractionDigits: 2 }).format(product.price) }} MXN</p>
                </div>
                <div class="col col-price">
                  <number-input size="small" v-model="product.cantidad" :min="1" :max="product.stock" @change="updateCarrito" inline controls rounded></number-input>
                </div>
              </div>

              
              <!-- <h6 class="mt-5">Cupones</h6>
              <hr class="c-hr" />

              <div class="row mx-0 no-gutters">
                <form class="col-12" @submit.prevent="ingresarCupon()" v-if="!descuentoAplicado">
                  <div class="col-12 text-center">
                    <label>Tienes algun cupón promocional?</label>
                  </div>
                  <div class="col-4 offset-4 text-center">
                    <b-form-group class="custom-input">
                      <b-form-input type="text" v-model="cupon" size="sm" required placeholder="Escribe aqui tu cupón"/>
                    </b-form-group>
                  </div>

                  <div class="col-12 text-center py-2">
                    <button type="submit" class="btn btn-outline-danger btn-sm">Canjear</button>
                  </div>
                </form>
                <div class="col-12 text-center" v-if="descuentoAplicado">
                  <label style="color: green">Cupón aplicado: {{cupon}} descuento del {{descuento}}%</label>
                </div>
              </div> -->

            </div>
            <!-- paso 1, Fin -->

            <!-- Paso 2 (Envio, Datos del usuario y datos de envío) -->
            <div class="col-12 py-4 px-4 user-data" v-if="$route.params.step == 'envio'">
              <h6>Datos de personales</h6>
              <hr class="c-hr" />

              <div class="custom-input _p">
                <label class="col-form-label pt-0">Nombre:</label>
                <p class="txt-simple" v-if="userLogin" v-text="form.user.name"></p>
                <b-form-input id="user-name" v-else type="text" v-model="form.user.name" size="sm" required placeholder="Nombre" validate="required" required/>
              </div>

              <div class="custom-input _p">
                <label class="col-form-label pt-0">Apellidos:</label>
                <p class="txt-simple" v-if="userLogin" v-text="form.user.lastname"></p>
                <b-form-input id="user-lastname" v-else type="text" v-model="form.user.lastname" size="sm" required placeholder="Apellidos" validate="required" required/>
              </div>

              <div class="custom-input _p">
                <label class="col-form-label pt-0">Correo electrónico:</label>
                <p class="txt-simple" v-if="userLogin" v-text="form.user.email"></p>
                <b-form-input id="user-email" v-else type="text" v-model="form.user.email" size="sm" required placeholder="Correo electrónico" validate="required" required/>
              </div>

              <div class="custom-input _p">
                <label class="col-form-label pt-0">Teléfono:</label>
                <!-- <p class="txt-simple" v-if="userLogin" v-text="form.user.phone"></p> -->
                <b-form-input id="user-phone" type="text" v-model="form.user.phone" size="sm" required placeholder="Teléfono" maxlength="10" validate="required" required/>
              </div>


              <h6 class="mt-5">Información de envío</h6>
              <hr class="c-hr" />

              <div class="row mx-0 no-gutters">
                <div class="col-md-7 col-lg-6">
                  <b-form-group class="custom-input" label="Calle:" label-for="i-calle">
                    <b-form-input id="i-calle" type="text" v-model="form.user.street" size="sm" required />
                  </b-form-group>
                </div>
                <div class="col-md pl-md-3">
                  <b-form-group class="custom-input" label="Numero ext:" label-for="i-numext">
                    <b-form-input id="i-numext" type="text" v-model="form.user.num_ext" size="sm" required placeholder="0000" />
                  </b-form-group>
                </div>

                <div class="col-md pl-md-3">
                  <b-form-group class="custom-input"
                    label="Numero int:"
                    label-for="i-numint">
                    <b-form-input id="i-numint" type="text" v-model="form.user.num_int" size="sm" placeholder="0000" />
                  </b-form-group>
                </div>
              </div>

              <div class="row mx-0 no-gutters">
                <div class="col-md-4 pr-md-3">
                  <b-form-group class="custom-input" label="Código postal:" label-for="i-cp">
                    <v-select v-model="form.user.postalCode" :filterable="true" :on-search="getZipCode" :options="zipCodes" @change="infoZipCode">
                      <template slot="no-options">
                        Escriba para buscar el código postal...
                      </template>
                    </v-select>
                  </b-form-group>
                </div>

                <div class="col-md-8">
                  <b-form-group class="custom-input" label="Colonia:" label-for="i-colonia">
                    <v-select v-model="form.user.neighborhood" :options="colonias"/>
                  </b-form-group>
                </div>
              </div>


              <div class="row mx-0 no-gutters">
                <div class="col-md-6 pr-md-3">
                  <b-form-group class="custom-input" label="Estado:" label-for="i-estado">
                    <v-select v-model="form.user.state_id" :options="estados" label="name" index="id"/>
                  </b-form-group>
                </div>

                <div class="col-md-6">
                  <b-form-group class="custom-input" label="Ciudad:" label-for="i-ciudad">
                    <v-select v-model="form.user.town_id" :options="ciudades" label="name" index="id"/>
                  </b-form-group>
                </div>
              </div>

              <div class="row mx-0 no-gutters py-3">
                  <b-form-checkbox id="checkbox-1" v-model="facturacion.factura" name="checkbox-1">Solicitar Factura</b-form-checkbox>
              </div>
              <template v-if="facturacion.factura">
                <h6 class="mt-4">Datos de facturación</h6>
                <hr class="c-hr"/>

                <div class="row mx-0 no-gutters">
                  <div class="col-md-6 pr-md-3">
                    <b-form-group class="custom-input" label="Nombre:" label-for="f-nombre">
                      <b-form-input id="f-nombre" type="text" v-model="facturacion.nombre" size="sm" required/>
                    </b-form-group>
                  </div>

                  <div class="col-md-6">
                    <b-form-group class="custom-input" label="Rfc:" label-for="f-rfc">
                      <b-form-input id="f-rfc" type="text" v-model="facturacion.rfc" size="sm" required/>
                    </b-form-group>
                  </div>
                </div>

                <div class="row mx-0 no-gutters">
                  <div class="col-md-12 col-lg-12">
                    <b-form-group class="custom-input" label="Cuenta con la que se realizará el pago:" label-for="f-cuente">
                      <b-form-input id="f-cuenta" type="text" v-model="facturacion.cuenta" size="sm" required />
                    </b-form-group>
                  </div>
                </div>

                <div class="row mx-0 no-gutters">

                  <div class="col-md-6 pr-md-3">
                    <b-form-group class="custom-input" label="Tipo de comprobante:" label-for="fcomprobante">
                      <b-form-select id="fcomprobante" v-model="facturacion.tipo" size="sm" required>
                        <option :value="null">Seleccione una opcion</option>
                        <option value="Adquisición de nercancias">Adquisición de mercancias</option>
                        <option value="Devoluciones, descuentos o bonificaciones">Devoluciones, descuentos o bonificaciones</option>
                        <option value="Gastos en general">Gastos en general</option>
                        <option value="Construcciones">Construcciones</option>
                        <option value="Mobilario y equipo de oficina por inversiones">Mobilario y equipo de oficina por inversiones</option>
                        <option value="Equipo de transporte">Equipo de transporte</option>
                        <option value="Equipo de computo y accesorios">Equipo de computo y accesorios</option>
                        <option value="Dados, troquetes, moldes, matrices y herramental">Dados, troquetes, moldes, matrices y herramental</option>
                        <option value="Comunicaciones telefónicas">Comunicaciones telefónicas</option>
                        <option value="Comunicaciones satelitales">Comunicaciones satelitales</option>
                        <option value="Otra maquinaria y equipo">Otra maquinaria y equipo</option>
                        <option value="Por definir">Por definir</option>
                      </b-form-select>
                    </b-form-group>
                  </div>

                  <div class="col-md-6">
                    <b-form-group class="custom-input" label="Correo" label-for="fcorreo">
                      <b-form-input id="fcorreo" v-model="facturacion.correo" size="sm" type="email" required></b-form-input>
                    </b-form-group>
                  </div>
                </div>

                <div class="row mx-0 no-gutters">
                      <div class="col-md-6 pr-md-3">
                        <b-form-group class="custom-input" label="Dirección" label-for="fdireccion">
                          <b-form-input id="fdireccion" v-model="facturacion.direccion" size="sm" type="text" required></b-form-input>
                        </b-form-group>
                      </div>
                      <div class="col-md-3 pr-md-3">
                        <b-form-group class="custom-input" label="Numero Exterior" label-for="fext">
                          <b-form-input id="fext" v-model="facturacion.no_ext" size="sm" type="text" required></b-form-input>
                        </b-form-group>
                      </div>
                      <div class="col-md-3">
                        <b-form-group class="custom-input" label="Numero Interior" label-for="fint">
                          <b-form-input id="fint" v-model="facturacion.no_int" size="sm" type="text"></b-form-input>
                        </b-form-group>
                      </div>
                  </div>
                  <div class="row mx-0 no-gutters">
                      <div class="col-md-6 pr-md-3">
                        <b-form-group class="custom-input" label="Telefono" label-for="iftelefono">
                          <b-form-input id="ftelefono" v-model="facturacion.telefono" size="sm" type="text" required></b-form-input>
                        </b-form-group>
                      </div>
                      <div class="col-md-6">
                        <b-form-group class="custom-input" label="Codigo Postal" label-for="fcp">
                          <b-form-input id="fcp" v-model="facturacion.cp" size="sm" type="text" required></b-form-input>
                        </b-form-group>
                      </div>
                  </div>
                  <div class="row mx-0 no-gutters">
                      <div class="col-md-4 pr-md-3">
                        <b-form-group class="custom-input" label="Estado" label-for="festado">
                          <v-select id="festado" v-model="facturacion.estado" :options="festados" label="name" index="id" @change="getFciudades" required/>
                        </b-form-group>
                      </div>
                      <div class="col-md-4 pr-md-3">
                        <b-form-group class="custom-input" label="Ciudad" label-for="fciudad">
                          <v-select id="fciudad" v-model="facturacion.ciudad" :options="fciudades" label="name" index="id" required/>
                        </b-form-group>
                      </div>
                      <div class="col-md-4">
                        <b-form-group class="custom-input" label="Colonia" label-for="fcolonia">
                          <b-form-input id="fcolonia" v-model="facturacion.colonia" size="sm" type="text" required></b-form-input>
                        </b-form-group>
                      </div>
                  </div>
              </template>

            </div>
            <!-- Paso 2, fin  -->

            <!-- Paso 3 (pago) -->
            <div class="col-12 py-4 px-4 user-data" v-if="$route.params.step == 'pago'">
              <h6>Información de pago</h6>
              <hr class="c-hr" />

              <div class="custom-input _p">
                <label class="col-form-label pt-0">Seleccione una forma de pago:</label>
              </div>

              <div class="row mb-4 payment-options-container">
                <div class="col col-box" @click="changePaymentMe('transferencia')">
                  <div class="box" v-bind:class="{ active: form.tipoPago == 'transferencia' }">
                    <h6>Transferencia<br />bancaria</h6>
                    <p class="icons">
                      <i class="fas fa-money-check-alt"></i>
                      <i class="fas fa-money-bill"></i>
                    </p>
                  </div>
                </div>

                <div class="col col-box" @click="changePaymentMe('paypal')">
                  <div class="box" v-bind:class="{ active: form.tipoPago == 'paypal' }">
                    <h6>PayPal</h6>
                    <p class="icons">
                      <i class="fab fa-paypal"></i>
                    </p>
                  </div>
                </div>

              </div>

              <!-- Pago 2, con transferencia bancaria -->
              <div class="col-12 text-center" v-if="form.tipoPago == 'transferencia'">
                <div v-html="deposito"></div>
              </div>

              <!-- paypal -->
              <div class="col-12 text-center" v-show="form.tipoPago == 'paypal'">
                <div id="paypal-button"></div>
              </div>
              
            </div>
            <!-- Paso 3, fin -->
          </b-form>

          <div class="row mx-0 py-3 px-lg-0 no-gutters row-total">
            <div class="col-lg-6" v-if="form.products.length">
              <button class="btn btn-outline-danger btn-sm btn-action" @click="getSteps(form.prev)" v-if="form.prev != null">Anterior</button>
              <button class="btn btn-outline-danger btn-sm btn-action" @click="getSteps(form.next)" v-if="form.next != null">Siguiente</button>
              <button class="btn btn-danger btn-sm btn-action" v-if="form.paying && form.tipoPago == 'transferencia'" @click="pagarCart()" :disabled="pedido_id">REALIZAR PEDIDO</button>
            </div>

            <div class="col-lg-6 text-right" v-if="form.products.length">
              <h6><span>Subtotal: </span> $ {{ Intl.NumberFormat("en-US", { minimumFractionDigits: 2 }).format(subtotal) }} MXN</h6>
              <h6 v-if="descuentoAplicado"><span>Descuento: </span><strike>{{ Intl.NumberFormat("en-US", { minimumFractionDigits: 2 }).format(cantidadDescontada) }} MXN</strike></h6>
              <h6 v-if="descuentoAplicado && subtotalDescontado"><span>Subtotal: </span>{{ Intl.NumberFormat("en-US", { minimumFractionDigits: 2 }).format(subtotalDescontado) }} MXN</h6>
              <h6><span>Envío: </span> $ {{ Intl.NumberFormat("en-US", { minimumFractionDigits: 2 }).format(form.envio) }} MXN</h6>
              <h5><span>Total: </span> $ {{ Intl.NumberFormat("en-US", { minimumFractionDigits: 2 }).format(total) }} MXN</h5>
            </div>
          </div>
        </div>
      </div>

      <sweet-modal :icon="modal.icon" :blocking="modal.block" :hide-close-button="modal.block"  ref="modal">
        <div class="fa-3x" v-if="modal.icon== ''"><i class="fas fa-spinner fa-pulse"></i></div><br/>
        <div v-html="modal.msg"></div>
        <div class="col-12 text-center" style="padding-top: 20px;" v-if="modal.icon == 'success'">
          <b-button class="btn btn-success" slot="button" v-on:click.prevent="$refs.modal.close(); $router.push('/')">Regresar a Home <i class="color-white fas fa-home"></i></b-button>
        </div>
      </sweet-modal>

      <sweet-modal :icon="'error'" :blocking="false" :hide-close-button="false"  ref="modallogin">
        El correo electrónico que ingreso, ya se encuentra registrado. Favor de iniciar sesión o puede recuperar su contraseña si no la recuerda.
        <div class="col-12 text-center" style="padding-top: 20px;">
          <b-button class="btn btn-primary" slot="button" v-on:click.prevent="$refs.modallogin.close(); $router.push('/recuperar-contrasena')">Recuperar contraseña <i class="fas fa-key"></i></b-button>
          <b-button class="btn btn-success" slot="button" v-on:click.prevent="$refs.modallogin.close(); $router.push('/login')">Iniciar sesión <i class="fas fa-sign-in-alt"></i></b-button>
        </div>
      </sweet-modal>

      <sweet-modal :icon="modal.icon" :blocking="modal.block" :hide-close-button="modal.block"  ref="cupon">
        <div class="fa-3x" v-if="modal.icon== ''"><i class="fas fa-spinner fa-pulse"></i></div><br/>
        {{ modal.msg }}
      </sweet-modal>

    </div>
  </div>
</template>

<script>
export default {
  data(){
    return{

      form: {
        products: [],
        user: {
          "email": '',
          "name": '',
          "lastname": '',
          "phone": '',
          "street": '',
          "num_ext": '',
          "num_int": '',
          "neighborhood":"",
          "postalCode": null,
          "state_id": null,
          "town_id": null
        },
        
        prev: '',
        next: '',
        paying: false,
        tipoPago: '',
        subtotal: 0,
        total: 0,
        envio: 148.00,
      },

      //Variables para los cupones
        cupon:'',
        descuentoAplicado:false,
        cantidadDescontada:0,
        subtotalDescontado:0,
        id_cupon:'',
        descuento:'',

      //Variables para el formulario de facturacion
      facturacion:{
        factura:false,
        nombre:'',
        rfc:'',
        tipo:null,
        cuenta:'',
        correo:'',
        direccion:'',
        no_ext:'',
        no_int:'',
        calles:'',
        telefono:'',
        cp:'',
        colonia:'',
        ciudad:null,
        estado:null
      },

      userLogin: false,
      zipCodes: [],
      colonias: [],
      estados: [],
      ciudades: [],
      fciudades: [],
      festados: [],
      paqueteria: 100.00,
      deposito: '',
      modal:{
              msg:'',
              icon:'',
              block:false,
              carrito:true
            },

      pedido_id: null
    }
  },

  computed: {
    subtotal() {
     var subtotal = this.form.products.reduce(function (subtotal, item) {
        return subtotal + (item.price * item.cantidad)
      },0);

      if(this.descuentoAplicado){
        this.cantidadDescontada = (subtotal * (this.descuento / 100)); //CUIDADO!!!, hay que validar que el descuento en la base de datos nunca sea 0;
        this.subtotalDescontado = parseFloat(subtotal) - (subtotal * (this.descuento / 100));
      }

      return this.form.subtotal = subtotal;
    },

    total() {
      var subtotal = this.form.products.reduce(function (sum, item) {
        return sum +  (item.price * item.cantidad)
      },0);

      var total  = parseFloat(subtotal) - this.cantidadDescontada;
      var grandTotal  = parseFloat(total) + parseFloat(this.form.envio);

      return this.form.total = grandTotal;
    }
  },

  methods: {
    getZipCode(search, loading) {
      if(search.length >= 4){
        axios.get(tools.url("/getZipCode/"+search)).then(response => {
          this.zipCodes = response.data;
        }).catch((error)=>{
          console.log(error);
        });
      }
    },

    infoZipCode() {
      if(this.form.user.postalCode.length == 5){
        //clear
        this.form.user.town_id = null;
        this.form.user.state_id = null;
        this.form.user.neighborhood = "";

        axios.get(tools.url("/infoZipCode/"+this.form.user.postalCode)).then(response => {
          this.estados = response.data.states;
          this.ciudades = response.data.towns;
          this.colonias = response.data.colonias;
          //asignar valores por default
          this.form.user.town_id = response.data.towns[0].id;
          this.form.user.state_id = response.data.states[0].id;

        }).catch((error)=>{
          console.log(error);
        });
      }
    },

    changePaymentMe(tipo){
      this.form.tipoPago = tipo;
    },

    ingresarCupon: function(){
        this.modal.block = true;
        this.modal.icon = '';
        this.modal.msg = 'Validando cupón, por favor espere...';
        this.$refs.cupon.open();

        var cupon = {cupon:this.cupon, user_id:this.$root.user.id, carrito:this.carrito};
        axios.post(tools.url('/front/buscarCupon'),cupon).then((response)=>{
          if(response.data.msg == "cupon valido"){
            this.id_cupon = response.data.cupon.id;
            this.descuento = response.data.cupon.porcentaje;
            this.descuentoAplicado = true;
            //mensaje
            this.modal.block = false;
            this.modal.icon = 'success';
            this.modal.msg = 'Su cupón le ha otorgado '+response.data.cupon.porcentaje+'% de descuento en su compra';

          } else{
            this.$refs.cupon.close();
            this.$bvToast.toast(`Error: ${response.data.msg}`, {
              title: `Cupon`,
              toaster: 'b-toaster-bottom-center',
              variant: 'danger',
              solid: true,
              appendToast: true
            });
          }
        }).catch((error)=>{
          this.$refs.cupon.close();
          console.log(error);
        });
    },

    showModal(msg,icon){
        this.modal.msg = msg;
        this.modal.icon = icon;
        this.$refs.modal.open();
    },

    getEstados(){
      axios.get(tools.url('/estados')).then((response)=>{
        this.festados = response.data;
      }).catch((error)=>{
         console.log(error);
      });
    },

    getCiudades(){
      if(this.form.user.state_id){
        axios.get(tools.url('/ciudades/' + this.form.user.state_id)).then((response)=>{
          this.ciudades = response.data;
        }).catch((error)=>{
          console.log(error);
        });
      }
    },

    getFciudades(){
      axios.get(tools.url('/ciudades/' + this.facturacion.estado)).then((response)=>{
        this.fciudades = response.data;
      }).catch((error)=>{
        console.log(error);
      });
    },

    obtenerCarrito: function(){
      var storage = localStorage.getItem('carrito');
      if(storage != null){
        var productos = JSON.parse(storage);
        axios.post(tools.url('/carrito/obtenerProductos'),{ productos:productos }).then((response)=>{
          this.form.products = response.data.cart;
          this.deposito = response.data.deposito.value;
          this.paqueteria = 100;
          this.getSteps();

        }).catch((error)=>{
          console.log(error);
          alert("ERROR02: Fallo la consulta del carrito, Verifique su internet y recargue la página");
          localStorage.removeItem('carrito');
          this.getSteps();
        });
      }
    },

    removeCart: function(index) {
        this.$delete(this.form.products, index)
        this.updateCarrito();
    },

    updateCarrito(){
        var carrito = [];
        this.form.products.forEach(function(val, index, array){
          var info = { id:val.id, cantidad: val.cantidad };
          carrito.push(info);
        });
        localStorage.setItem("carrito",JSON.stringify(carrito));
        this.$root.carritoCount = carrito.length;
    },

    pagarCart: function(){
      var cuponData = {
        cupon:this.cupon,
        descuento:this.descuento,
        descuentoAplicado:this.descuentoAplicado,
        cantidadDescontada:this.cantidadDescontada,
      };

      this.modal.block = true;
      this.modal.icon = '';
      this.modal.msg = 'Procesando, por favor espere...';
      this.$refs.modal.open();

      axios.post(tools.url('/front/guardar-pedido'),{  pedido:this.form, products:this.form.products, user:this.form.user, userLogin:this.userLogin, factura:this.facturacion, cupon:cuponData }).then((response)=>{
          if(response.data.type === "success"){
            this.pedido_id = response.data.order_id;
            localStorage.removeItem('carrito');
            this.$root.carritoCount = 0;
            //mensaje
            this.modal.icon = "success";
            this.modal.msg = "Tu pedido se completo de forma exitosa!<br/> El número de pedido es "+response.data.order_id+". Porfavor envía tu comprobante de pago a ventas@vsexshopgdlalcala.com.mx antes de las próximos 2 dias. <br/> Cualquier duda o comentario comunícate al correo antes mencionado o al Whatsapp: 3312428001";
            this.modal.block = true;

          }else{
            if(response.data.error == "El correo electronico ya esta en uso"){
              this.$refs.modal.close();
              this.$refs.modallogin.open();
            }else{
              this.$refs.modal.close();
              alert(response.data.error);
            }
          }
      }).catch((error)=>{
        console.log(error);
        this.modal.icon="error";
        this.modal.msg = "Fallo al realizar el pedido., Verifique su internet y recargue la página";
        this.modal.block = false;
      });

    },

    recuperarInfo(){
      //
      this.form.user = {
        //Datos personales
        id: this.$root.user.id,
        name: this.$root.user.name,
        lastname: this.$root.user.lastname,
        email: this.$root.user.email,
        phone: this.$root.user.phone,
        customer_id: this.$root.user.customer.id,
        //Información de envío
        street: this.$root.user.customer.street,
        num_ext: this.$root.user.customer.num_ext,
        num_int: this.$root.user.customer.num_int,
        neighborhood: this.$root.user.customer.neighborhood,
        postalCode: this.$root.user.customer.postalCode,
        state_id: this.$root.user.customer.state_id,
        town_id: this.$root.user.customer.town_id,
      };

      this.userLogin = true;
      this.getCiudades();
    },

    getSteps(n){
      var step = n;
      // var step = this.$route.params.step;
      // this.form.paying = false;

      if(step == 'pago'){ // Paso 3
        if (this.form.user.name == null || this.form.user.name == '') {
          alert("Ingrese su nombre completo");
          return false;
        }
        else if (this.form.user.email == null || this.form.user.email == '') {
          alert("Ingrese su correo electrónico");
          return false;
        }
        else if (this.form.user.phone == null || this.form.user.phone == '') {
          alert("Ingrese su teléfono");
          return false;
        }
        else if (this.form.user.street == null || this.form.user.street == '') {
          alert("ingrese su dirección");
          return false;
        }
        else if (this.form.user.num_ext == null || this.form.user.num_ext == '') {
          alert("Ingrese su número exterior");
          return false;
        }
        else if (this.form.user.neighborhood == null || this.form.user.neighborhood == '') {
          alert("Ingrese su colonia");
          return false;
        }
        else if (this.form.user.postalCode == null || this.form.user.postalCode == '') {
          alert("Ingrese su código postal");
          return false;
        }
        else if (this.form.user.state_id == null) {
          alert("selecione su estado");
          return false;
        }
        else if (this.form.user.town_id == null) {
          alert("selecione su ciudad");
          return false;
        }else{
          this.$route.params.step = n;
          this.form.paying = false;

          this.form.prev = 'envio';
          this.form.next = null;
          this.form.paying = true;
        }
      }
      else if(step == 'envio'){ // Paso 2
        this.$route.params.step = n;
        this.form.paying = false;

        this.form.prev = '';
        this.form.next = 'pago';
      }
      else{ // Paso 1
        this.$route.params.step = n;
        this.form.paying = false;

        this.form.prev = null;

        if(this.form.products.length){
          this.form.next = 'envio';
        }
      }
    },

    cargarBoton(){
          //Aqui pasamos el apuntador para que pueda reconocer las variables de nuestro componente en las funciones de Javascript de paypal
          var self = this;
          var cuponData = {
            cupon:self.cupon,
            descuento:self.descuento,
            descuentoAplicado:self.descuentoAplicado,
            cantidadDescontada:self.cantidadDescontada,
          };
          //Ahora si, aquí se renderiza el boton de paypal con la informacion de adentro.
          paypal.Button.render({
          env: 'production', // Modo de operacion, las opciones son: "sandbox" o "production"
          client:{
            sandbox:'ARuYHn9_M55g1VNQaw_FKQZgV-nrcWY6OE8Nf0Sxm6J39VLfgJBv6Qh6jNVBbcHVxyySHY0oWmkFlfW2',
            production:'Af0n72IpHSquHsR-yBwXbzRM4zmps_4rxtQ5X9I_Xa6fTRg3aV483AdEdI63LmLUJnXqrPwUlFPEvG0r',
          },
          style: {  //Estilos del boton
            size: 'large', color: 'black', shape: 'rect',
          },

          // Primero creamos el pedido
          payment: async function(data, actions) {
            return actions.request.post(tools.url('/api/paypal/payment'),{
              method: 'post',
              headers: { "Content-Type" : "application/json"}, //Colocamos el typo de contenido como JSON
              body: JSON.stringify({ pedido:self.form, products:self.form.products, user:self.form.user, cupon:cuponData, userLogin:self.userLogin}) //Adjuntamos la informacion del pedido
            }).then(function(response){ //Si todo sale bien deberiamos poder obtener el id del pedido
              if(response.estado == 'ok'){
                return response.payment_id; //Aqui practicamente regresamos el id de la compra.
                self.modal.block = true;
                self.modal.icon = '';
                self.modal.msg = 'Procesando, por favor espere...';
                self.$refs.modal.open();

              }else{
                if(response.error == "El correo electronico ya esta en uso"){
                  self.$refs.modallogin.open();
                }else{
                  self.modal.icon="error";
                  self.modal.msg = response.error ? response.error : "Ocurrió un error al conectarse a PAYPAL por favor intente mas tarde!";
                  self.modal.block = false;
                  self.$refs.modal.open();
                }
              }
            }).catch(function(error){
              self.modal.icon="error";
              self.modal.msg = "Ocurrió un error al conectarse a PAYPAL por favor intente mas tarde!";
              self.modal.block = false;
              self.$refs.modal.open();
            });

          },

          onAuthorize: function(data, actions) {
            return actions.request.post(tools.url('/api/paypal/onAuthorize'),{
              method: 'post',
              headers:{ "Content-Type":'application/json'},
              paymentID: data.paymentID,
              payerID: data.payerID,
              body: JSON.stringify({ pedido:self.form, products:self.form.products, user:self.form.user, userLogin:self.userLogin, factura:self.facturacion, cupon:cuponData })
            }).then(function(response)
            {
              //console.log(response);
              if(response.estado == 'ok')
              {
                self.modal.icon = "success";
                self.modal.msg = "Su pago se completo de forma exitosa. <br/>El número de pedido es "+response.data.order_id+". <br/> Cualquier duda o comentario comunícate al correo ventas@vsexshopgdlalcala.com.mx o al Whatsapp: 3312428001";
                self.modal.block = true;
                self.$refs.modal.open();

                localStorage.removeItem('carrito');
                self.$root.carritoCount = 0;

              }else{
                self.modal.icon="error";
                self.modal.msg = "Su pago no pudo concretarse por favor intente mas tarde!";
                self.modal.block = false;
                self.$refs.modal.open();
              }

            }).catch(function(error){
              self.modal.icon="error";
              self.modal.msg = "Ocurrió un error al conectarse a PAYPAL por favor intente mas tarde!";
              self.modal.block = false;
              self.$refs.modal.open();

            });
          }

      }, '#paypal-button');
       $('#paypal-button').show();
    },
  },

  beforeMount(){
    
    if(this.$root.logged){
      this.recuperarInfo();
    }

    this.obtenerCarrito();
    this.getEstados();
  },

  watch: {
    '$route.params.step': function () {
      this.getSteps();
    },

    "form.tipoPago" : function(v){
      if(v == "paypal"){
        this.cargarBoton();
      }else{
        $('#paypal-button').html("");
        //this.isModalCuentasActive =true;
      }
    },

    "$root.logged": function(v) { //Cuando se recarga la pagina y el usuario ya tiene una sesion. Este watcher espera a que el app.js termine la peticion de recuperacion del usuario.
      if(v == true)
        this.recuperarInfo();
    },
  }
}
</script>
