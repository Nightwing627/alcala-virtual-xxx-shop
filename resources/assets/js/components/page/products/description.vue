<template lang="html">
  <div id="description-page">
    <div class="loading" v-if="loading"></div>

    <div v-if="!loading">
      <section class="breadcrumb-section">
        <div class="container oversized-container">
          <span>Categorías</span>
          <span class="line">/</span>
          <router-link :to="'/categoria/'+category.id" v-if="category.name">{{ category.name }}</router-link>
          <span class="line">/</span>
          <span>{{ product.name }}</span>
        </div>
      </section>

      <section class="container oversized-container description-section" id="product-description">
        <div class="row">

          <div class="col-lg-6 col-gallery">
            <swiper :options="galleryOptions">
              <swiper-slide v-if="product.video">
                <div class="image-container">
                  <div class="video" >
                    <img src="public/images/pages/products/empty.png">

                    <video autoplay muted loop>
                      <source :src="product.video" type="video/mp4">
                      Your browser does not support the video tag.
                    </video>
                  </div>
                </div>
              </swiper-slide>

              <swiper-slide v-for="(row, galIndex) in gallery" :key="galIndex">
                <div class="image-container">
                  <div class="img">
                    <!-- <v-zoom :img="row" :width="'100%'"></v-zoom> -->
                    <img :src="row">
                  </div>
                </div>
              </swiper-slide>

              <div class="swiper-pagination" slot="pagination"></div>
            </swiper>
          </div>

          <b-form class="col-lg-5 col-description" @submit="addCart">
            <!-- <div class="bar-fav">
              <button type="button" class="btn-fav actived"><i class="icon"></i></button>
            </div> -->

            <h6 class="brand" v-if="category.name">{{ category.name }}</h6>

            <h1 class="name">{{ product.name }}</h1>
            <small>SKU: {{ product.sku }}</small>
            <h4 class="price">$ {{ product.price }}</h4>

            <h6 class="mt-2 subtitle">Descripción</h6>
            <!-- <div class="mb-0 txt-description" v-html="product.description"></div> -->
            <div class="txt-description" v-html="product.description"></div>
            <small v-if="product.measure">Medida: {{ product.measure }}</small>

            <!-- <h6 class="subtitle">Ficha técnica</h6>
            <div class="txt-description" v-html="product.fichatecnica"></div>

            <h6 class="subtitle">Garantía</h6>
            <div class="txt-description" v-html="product.garantia"></div>

            <h6 class="subtitle">Dimensiones</h6>
            <div class="txt-description">{{ product.dimensions }}</div> -->

            <h6 class="mt-2 subtitle">Cantidad</h6>
            <div class="row no-gutters pt-0 box-options" >
              <!-- <div class="col col-opts col-sizes">
                <b-form-select v-model="form.size" required class="mb-1 custom-ro-select">
                  <option :value="null">Tallas</option>
                  <option value="8.5">8.5</option>
                  <option value="9.0">9.0</option>
                  <option value="10.0">10.0</option>
                  <option value="10.5">10.5</option>
                </b-form-select>
              </div> -->

              <div class="col col-opts col-quantity">
                <b-form-select v-model="form.quantity" required class="mb-1 custom-ro-select">
                  <option :value="null"> </option>
                  <option :value="index + 1" v-for="(q, index) in product.stock">{{ index + 1 }}</option>
                </b-form-select>
              </div>
            </div>

            <!-- <div class="box-colors">
              <h5 class="subtitle">Colores</h5>

              <div class="wrapper">
                <b-form-radio
                  v-model="form.color"
                  required
                  name="r-color"
                  class="input-color-opt"
                  :value="colDeIndex"
                  v-for="(color, colDeIndex) in colors"
                  :key="colDeIndex">
                  <div class="box-color-opt">
                    <a class="color" title="Color x" v-bind:class="{ 'img-outli' : color.img }" v-bind:style=" color.hex ? 'background-color:' + color.hex : 'background-image: url(' + color.img + ')' "></a>
                  </div>
                </b-form-radio>
              </div>
            </div> -->

            <div class="d-block my-2">
              <b-button type="submit" class="my-2 my-xl-0 btn-submit">Agregar al carrito <i class="fal fa-shopping-cart"></i></b-button>
              <router-link class="ml-xl-3 my-2 my-xl-0 btn btn-submit btn-contact" :to="{ name: 'contactPage', query: { p: product.name+', SKU: '+product.sku } }"><strong class="f-w-600">Contactar</strong> <i class="far fa-envelope"></i></router-link>
            </div>

            <hr />

            <div class="col-12 col-extra" id="col-extra">
              <div class="row">
                <div class="col b-sharing">
                  <h6>Compartir</h6>

                  <ShareNetwork
                    v-for="(network, pdInx) in networks"
                    :network="network.network"
                    :key="network.network"
                    :style="{backgroundColor: network.color}"
                    :url="sharing.url"
                    :title="sharing.title"
                    :description="sharing.description"
                    :quote="sharing.quote"
                    :hashtags="sharing.hashtags"
                    :twitterUser="sharing.twitterUser">
                    <div class="btn-q"><span><i :class="network.icon"></i></span></div>
                  </ShareNetwork>

                </div>
              </div>
            </div>
          </b-form>

          <!-- <div class="col-11 mx-auto col-extrainfo">
            <div class="row row-info">
              <div class="col-lg-6 col-label">
                <h6>Ficha técnica</h6>
              </div>

              <div class="col-lg-6 col-txt" v-html="product.fichatecnica"></div>
            </div>

            <div class="row row-info">
              <div class="col-lg-6 col-label">
                <h6>Garantía</h6>
              </div>

              <div class="col-lg-6 col-txt" v-html="product.garantia"></div>
            </div>

            <div class="row row-info">
              <div class="col-lg-6 col-label">
                <h6>Dimensiones</h6>
              </div>

              <div class="col-lg-6 col-txt">
                {{ product.dimensions }}
              </div>
            </div>
          </div> -->

        </div>
      </section>

      <section class="container oversized-container related-products-section" id="related-products">
        <div class="col-12 pb-3">
          <h4 class="section-title">Te podría interesar</h4>
          <hr />
        </div>

        <div class="row justify-content-center sample-products-wrapper xxl-5e">
          <div class="col-sm-6 col-md-4 col-lg-3 sample-product" v-for="(product, index) in relatedProducts" :key="index">
            <router-link class="outlined-box" :to="'/producto/'+product.id">
              <div class="box-image">
                <div class="img">
                  <img :src="product.image">
                </div>
              </div>

              <div class="box-shot-descr">
                <!-- <h6 class="brand">{{ product.category.name }}</h6> -->
                <h6 class="name">{{ product.name }}</h6>
                <h6 class="price">${{ product.price }}</h6>

                <p class="descr" v-html="product.description"></p>
              </div>
            </router-link>
          </div>
        </div>
      </section>

      <!-- <section class="container oversized-container related-products-section" id="complementary-products" v-if="complementarios.length">
        <div class="col-12 pb-3">
          <h4 class="section-title">Otros productos</h4>
          <hr />
        </div>

        <div class="row justify-content-center sample-products-wrapper xxl-5e">
          <div class="col-sm-6 col-md-4 col-lg-3 sample-product" v-for="(product, index) in complementarios" :key="index">
            <router-link class="outlined-box" :to="'/producto/'+product.id">
              <div class="box-image">
                <div class="img">
                  <img :src="product.image">
                </div>
              </div>

              <div class="box-shot-descr">
                <h6 class="name">{{ product.name }}</h6>
                <h6 class="price">${{ product.price }}</h6>

                <p class="descr" v-html="product.description"></p>
              </div>
            </router-link>
          </div>
        </div>
      </section> -->
    </div>
  </div>
</template>

<script>
import vZoom from 'vue-zoom';
export default {
  components: {vZoom},
  data() {
    return {
      loading: true,

      id: null,
      form: {
        size: null,
        quantity: null,
        color: null
      },

      product: [],
      category: [],

      // == Sharing ==
      sharing: {
        url: 'https://vsexshopgdlalcala.com.mx/#/producto/',
        title: 'Virtual Sexshop GDL Alcala',
        description: '',
        quote: 'vsexshopgdlalcala.com.mx',
        hashtags: '',
        twitterUser: 'PierreAlcala1'
      },
      networks: [
        { network: 'twitter', name: 'Twitter', icon: 'fab fa-twitter' },
        { network: 'facebook', name: 'Facebook', icon: 'fab fa-facebook-f' },
        { network: 'whatsapp', name: 'Whatsapp', icon: 'fab fa-whatsapp' },
      ],
      // == ==

      colors: [],

      gallery: [],
      relatedProducts: [],
      complementarios: [],

      // == Carrusel options ==
      galleryOptions: {
        loop: true,
        speed: 600,

        pagination: {
          el: '.swiper-pagination',
          clickable: true
        },

        // autoplay: {
        //   delay: 3000,
        //   disableOnInteraction: false
        // }
      }
    }
  },

  watch: {
         "$route.params.id" : function(v){
              this.id = this.$route.params.id;
              this.product.gallery = [];
              this.getProduct();
        },

        "product" : function(v){
              this.sharing.url = 'https://vsexshopgdlalcala.com.mx/#/producto/'+this.id;
              this.sharing.title = this.product.name ? this.product.name : '';
              this.sharing.description = this.product.description ? this.product.description.replace( /(<([^>]+)>)/ig, '') : '';
              this.sharing.hashtags = this.product.tags ? this.product.tags : '';
        },
    },

  methods:{
    toast() {
      this.$bvToast.toast(`El producto fue agregado a su carrito`, {
        title: `Producto agregado al carrito`,
        toaster: 'b-toaster-bottom-right',
        variant: 'success',
        solid: true,
        appendToast: true
      })
    },

    getProduct(){
      this.loading = true;

      axios.get(tools.url('/producto/' + this.id)).then((response)=>{
        this.product = [];
        this.gallery = [];
        this.gallery = response.data.gallery;
        this.product = response.data;
        this.category = response.data.category;
        setTimeout( ()=> { this.loading = false; }, 500);

        if(this.product.imageUrl){
          this.product.gallery.unshift(this.product.imageUrl);
        }
        if(this.product.stock > 0){
          this.form.quantity = 1;
        }
        this.getRelacionados(this.product.category_id);
      }).catch((error)=>{
        console.log(error);
      });
    },

    addCart(evt){
      evt.preventDefault();
      var carrito = [];
      var encontrado = false;

      if(localStorage.carrito){
        carrito = JSON.parse(localStorage.getItem('carrito'));

        for(var i = 0; i < carrito.length ; i++){
          if(carrito[i].id == this.id){
            var suma = carrito[i].cantidad + this.form.quantity;
            carrito[i].cantidad = suma <= this.form.quantity ? suma : this.product.quantity;
            encontrado = true;
            break;
          }
        }

        if(!encontrado){
          carrito.push({ id:this.id, cantidad:this.form.quantity });
        }
      } else{
        carrito.push({ id:this.id, cantidad:this.form.quantity });
      }
      localStorage.setItem("carrito",JSON.stringify(carrito));
      this.$root.carritoCount = carrito.length;
      this.toast();
    },

    getRelacionados(id){
      axios.get(tools.url('/relacionados/'+id)).then((response)=>{
        this.relatedProducts = response.data;
      }).catch((error)=>{
        console.log(error);
      })
    },

    getComplementarios(id){
      axios.get(tools.url('/getComplementarios/'+id)).then((response)=>{
        this.complementarios = response.data;
      }).catch((error)=>{
        console.log(error);
      })
    },

  },

   mounted(){
    this.id = this.$route.params.id;
    this.getProduct();
  }
}
</script>
