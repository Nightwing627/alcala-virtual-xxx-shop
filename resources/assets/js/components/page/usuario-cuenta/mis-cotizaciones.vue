<template lang="html">
  <div class="col-cart-data loggedin-cart">

    <div class="col-12 pt-3 product-list-table" v-if="$route.params.step !== 'envio' && $route.params.step !== 'pago'">
      <div class="col-12 px-0 mb-2">
        <h5>Mis cotizaciones</h5>
      </div>

      <div class="row row-products align-items-center row-history" v-for="(product, index) in form.products">
        <div class="col col-image">
          <img src="public/images/pages/products/product-4.jpg">
        </div>

        <div class="col col-info">
          <h5 class="txt-name">
            <router-link to="">{{ product.name }}</router-link>
          </h5>
          <p class="txt-extra-info">
            Fecha: <strong>10 de Septiembre, 2019</strong>
          </p>
        </div>

        <div class="col col-status">
          <h6>
            <span class="label">Estatus: </span>
            <span class="status text-warning">No atendido</span>
          </h6>
        </div>
        <!-- <div class="col col-price">
          <p>$ 560.00 MXN</p>
        </div> -->
        <div class="col col-num">
          <h5 class="col-title">Cant.</h5>
          <p>10</p>
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
          { img: '', name: 'Cotización realizada', num: 0 },
          { img: '', name: 'Cotización realizada', num: 0 },
          { img: '', name: 'Cotización realizada', num: 0 },
          { img: '', name: 'Cotización realizada', num: 0 },
          { img: '', name: 'Cotización realizada', num: 0 },
        ]
      }
    }
  }
}
</script>
