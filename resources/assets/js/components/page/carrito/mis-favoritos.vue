<template lang="html">
  <div id="cart-page" class="d-flex account-page">
    <div class="container main-box">

      <div class="row">
        <div class="col-12 px-2">
          <h1 class="mb-3 page-title">Mis favoritos</h1>
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
                  <img :src="product.img">
                </div>

                <div class="col col-info">
                  <h5 class="txt-name">
                    <router-link target="_blank" to="/producto/1">{{ product.name }}</router-link>
                  </h5>

                  <div class="row mx-0 align-items-center">
                    <div class="d-flex">
                      <h6 class="txt-sm text-muted">Verde</h6>
                    </div>
                    <div class="d-flex">
                      <div class="box-color-opt opt-sm">
                        <a class="color" title="Color x" v-bind:style="{ backgroundColor: '#80c65d' }"></a>
                      </div>
                    </div>
                  </div>
                  <hr class="mt-0 mb-1" />

                  <router-link class="link-sm text-muted" to="/producto/1"><i class="fas fa-shoe-prints"></i> Ver producto</router-link> <span class="mx-2">|</span> <a class="link-sm text-info"><i class="fas fa-cart-plus"></i> Agregar</a> <span class="mx-2">|</span> <a class="link-sm text-danger"><i class="far fa-trash-alt"></i> Quitar</a>
                </div>

                <div class="col text-center col-price">
                  <p>$ 560.00 MXN</p>
                </div>
              </div>
            </div>
            <!-- paso 1, Fin -->


          </b-form>
        </div>
      </div>

    </div>
  </div>
</template>

<script>
export default {
  data(){
    return{
      form: {
        products: [
          { img: 'public/images/pages/products/product-1.jpg', name: 'Nombre de producto #54514', num: 0 },
          { img: 'public/images/pages/products/product-2.png', name: 'Nombre de producto #14524', num: 0 },
          { img: 'public/images/pages/products/product-3.png', name: 'Nombre de producto #2544', num: 0 },
          { img: 'public/images/pages/products/product-4.png', name: 'Nombre de producto #01410', num: 0 },
        ]
      }
    }
  },
}
</script>
