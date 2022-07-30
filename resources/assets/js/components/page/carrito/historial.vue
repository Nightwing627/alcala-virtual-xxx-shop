<template lang="html">
  <div id="cart-page" class="d-flex account-page">
    <div class="container main-box">

      <div class="row">
        <div class="col-12 px-2">
          <h1 class="mb-3 page-title">Historial de compras</h1>
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

          <div class="white-box">

            <div class="col-12 pt-3 product-list-table" v-if="$route.params.step !== 'envio' && $route.params.step !== 'pago'">
              <div class="col-12 px-0">
                <h5>Historial de compras</h5>
              </div>

              <div class="row row-products align-items-center row-history" v-for="(value, index) in historial">
                <div class="col col-image">
                  <img :src="value.productImage">
                </div>

                <div class="col col-info">
                  <h5 class="txt-name">
                    <router-link target="_blank" :to="'/producto/'+value.product_id">{{ value.productName }}</router-link>
                  </h5>
                </div>

                <div class="col col-info">
                  <h5 class="txt-name">
                    <p>{{ value.fecha }}</p>
                  </h5>
                </div>

                <div class="col col-status">
                  <h6>
                    <span class="label">Estatus: </span>
                    <span class="status text-warning" v-text="value.status"></span>
                  </h6>
                </div>
                <div class="col col-price">
                  <p v-text="'$'+ value.precio +' MXN'"></p>
                </div>
                <div class="col col-num">
                  <p v-text="value.cantidad"></p>
                </div>
              </div>
            </div>

          </div>

        </div>
      </div>

    </div>
  </div>
</template>

<script>
export default {
  data(){
    return{
      historial: [],
      form: {
        demos:[
          { img: 'public/images/pages/products/product-1.jpg', name: 'Nombre de producto #54514', num: 0 },
          { img: 'public/images/pages/products/product-2.png', name: 'Nombre de producto #14524', num: 0 },
          { img: 'public/images/pages/products/product-3.png', name: 'Nombre de producto #2544', num: 0 },
          { img: 'public/images/pages/products/product-4.png', name: 'Nombre de producto #01410', num: 0 },
        ]
      }
    }
  },

  methods: {
    getHistorial(){
      var customer_id = this.$parent.user.customer.id;
      axios.post(tools.url('/carrito/historial'),{customer_id: customer_id}).then((response)=>{
        this.historial = response.data;
      }).catch((error)=>{ 
        console.log('error'); 
      });
    },
  },

  beforeMount(){
    if(!this.$root.logged){
      this.$router.push("/login");
    }else{
      this.getHistorial();
    }
  }
}
</script>
