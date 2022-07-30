<template lang="html">
  <div id="home-page">


    <section class="container-fluid banner-section">
      <swiper :options="bannersOption" v-if="showCarousel">
        <swiper-slide v-for="(banner, index) in banners" :key="index">
          <a :href="banner.url ? banner.url : '#'"><img :src="banner.imageUrl" /></a>
        </swiper-slide>

        <!-- <div class="swiper-button-prev" slot="button-prev"></div>
        <div class="swiper-button-next" slot="button-next"></div> -->
      </swiper>
    </section>

    <section class="products-section">
      <!-- <div class="box-line"><hr /></div> -->

      <h2 class="title">Productos Destacados</h2>

      <div class="container oversized-container">
        <div class="row sample-products-wrapper xxl-5e">

          <div class="col-sm-6 col-md-4 col-lg-3 sample-product" v-for="product in products">
            <router-link class="outlined-box" :to="'/producto/'+product.id">
              <div class="box-image">
                <div class="img">
                  <img :src="product.img">
                </div>
              </div>

              <div class="box-shot-descr">
                <h6 class="brand">{{ product.category }}</h6>
                <h6 class="name">{{ product.name }}</h6>
                <h6 class="price">${{ product.price }}</h6>

                <p class="descr" v-html="product.description"></p>

                <p class="p-btn">
                  <a class="btn-more">Ver Más</a>
                </p>
              </div>
            </router-link>
          </div>

        </div>
      </div>

    </section>

    <section class="banners-sec-section" v-if="secundario">
      <a :href="secundario.url">
        <img :src="secundario.imageUrl">
      </a>
    </section>

    <section class="categories-section" v-if="cuadros.length">
      <div class="container oversized-container content">
        <div class="row">

          <div class="col-md-6 col-lg-4 col-category" v-for="(cuadro, cathInx) in cuadros" :key="'cath-'+cathInx">
            <a class="trans-150" :href="cuadro.url">
              <img class="empty" src="public/images/shared/empty.png">

              <div class="placed-backg box" v-bind:style="{ backgroundImage: 'url('+cuadro.imageUrl+')' }">
                <div class="inside">
                  <h4>{{ cuadro.name }}</h4>
                  <!-- <a class="trans-250">Ver Más</a> -->
                </div>
              </div>
            </a>
          </div>
        </div>
      </div>
    </section>

    <section class="products-section">
      <!-- <div class="box-line"><hr /></div> -->

      <h2 class="title">Productos Destacados</h2>

      <div class="container oversized-container">
        <div class="row sample-products-wrapper xxl-5e">

          <div class="col-sm-6 col-md-4 col-lg-3 sample-product" v-for="product in products">
            <router-link class="outlined-box" :to="'/producto/'+product.id">
              <div class="box-image">
                <div class="img">
                  <img :src="product.img">
                </div>
              </div>

              <div class="box-shot-descr">
                <h6 class="brand">{{ product.category }}</h6>
                <h6 class="name">{{ product.name }}</h6>
                <h6 class="price">${{ product.price }}</h6>

                <p class="descr" v-html="product.description"></p>

                <p class="p-btn">
                  <a class="btn-more">Ver Más</a>
                </p>
              </div>
            </router-link>
          </div>

        </div>
      </div>
    </section>

    <section class="newsletter-section-v1">
      <div class="container oversized-container">
        <div class="row flex-center-xy">
          <div class="col-md-6 col-lg-5 col-title">
            <h2>Suscríbete al Newsletter</h2>
          </div>

          <div class="col-md-6 col-lg-6 col-xl-5 col-form">
            <b-form @submit="onSubmit">
              <b-form-group>
                <b-form-input
                  v-model="form.email"
                  type="email"
                  required
                  placeholder="Ingrese su Correo Electrónico"
                ></b-form-input>
              </b-form-group>

              <b-button type="submit" class="btn-send">SUSCRIBIRSE</b-button>
            </b-form>
          </div>
        </div>
      </div>
    </section>

  </div>
</template>

<script>
export default {
  data() {
    return {
      showCarousel: false,

      banners: [],
      secundario: '',
      products: [],
      cuadros: [],

      form: {
        email: null
      },

      /* == Carousel options == */
      bannersOption: {
        loop: true,
        speed:800,
        effect: 'fade',

        navigation: {
          nextEl: '.swiper-button-next',
          prevEl: '.swiper-button-prev'
        },

        autoplay: {
          delay: 3500,
          disableOnInteraction: false
        },
      },
      // == ==
    }
  },

  methods: {
    getHome: function(){
      axios.get(tools.url('/home')).then(
        ({data}) =>{
          this.content = data;
          this.banners = this.content.banners;
          this.secundario = this.content.secundario;
          this.cuadros = this.content.cuadros;
          this.noticias = this.content.noticias;
          this.products = this.content.destacados;


          setTimeout( ()=> {
            this.showCarousel = true;
          }, 500);
        });
      },

    makeToast(variant = null, msg, title) {
      this.$bvToast.toast(msg, {
        title: title,
        variant: variant,
        solid: true,
        toaster: 'b-toaster-top-right',
        appendToast: true
      })
    },

      onSubmit(evt) {
        evt.preventDefault();
        var r = confirm("¿Deseas regístrate en newsletter? ");
        if (r == true) {
          axios.post(tools.url("/newsletter"), this.form).then((response)=>{
            this.makeToast('default', response.data.response, 'Mensaje enviado');
            this.form = {
              name: null,
              email: null,
              msg: null,
              check: null
            };
          }).catch( (error)=> {
            // console.log(error.response);
            let errors = error.response.data;
            // console.log(errors);
            this.makeToast('danger', error.response.data.name, 'Error');
            this.makeToast('danger', error.response.data.email, 'Error');
            this.makeToast('danger', error.response.data.phone, 'Error');
            this.makeToast('danger', error.response.data.msg, 'Error');
          });
        }

      }
    },

    mounted(){
      this.getHome();
    }
}
</script>
