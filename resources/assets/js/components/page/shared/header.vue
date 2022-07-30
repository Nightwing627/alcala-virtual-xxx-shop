<template lang="html">
  <header id="header">

    <div class="header-content">
      <!-- Header top -->
      <div class="header-top">
        <div class="container oversized-container">
          <div class="b-1">
            <h6 class="txt">Paga en línea con tu tarjeta de débito o crédito de forma segura</h6>

            <div class="imgs">
              <img class="mr-4" src="public/images/shared/i-shield.png">
              <img src="public/images/shared/i-american-express.png">
              <img src="public/images/shared/i-mastercard.png">
              <img src="public/images/shared/i-visa.png">
            </div>
          </div>

          <div class="b-2">
            <h6 class="txt">Compra discreta, en tu recibo aparecerá: Accesorios GDL.</h6>

            <!-- <div class="imgs">
              <img src="public/images/shared/i-card.png">
            </div> -->
          </div>
        </div>
      </div>
      <!--  -->

      <!-- Header middle -->
      <b-navbar toggleable="lg" type="dark" variant="info" class="header-middle">
        <div class="container oversized-container">
          <!-- <b-navbar-brand to="/">NavBar</b-navbar-brand> -->

          <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

          <b-collapse id="nav-collapse" is-nav>
            <b-navbar-nav class="mr-auto navbar-nav-menu">
              <li class="nav-item">
                <a class="nav-link link-network" target="_blank" href="https://www.facebook.com/Virtual-Sex-Shop-Gdl-Alcala-155949424445662/">
                  <i class="fab fa-facebook-square"></i>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link link-network" target="_blank" href="https://twitter.com/PierreAlcala1">
                  <i class="fab fa-twitter"></i>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link link-network" target="_blank" href="http://www.youtube.com/channel/UC9REkMYHl9tdEP3rz_f0QYA">
                  <i class="fab fa-youtube"></i>
                </a>
              </li>
            </b-navbar-nav>

            <b-navbar-nav class="mx-auto navbar-nav-logo">
              <b-dropdown-item class="link-logo" to="/">
                <img src="public/images/shared/logo.png">
              </b-dropdown-item>
            </b-navbar-nav>

            <b-navbar-nav class="ml-auto navbar-nav-menu">
              <b-nav-item-dropdown right>
                <template #button-content>
                  <span><i class="fal fa-user"></i></span>
                </template>
                <b-dropdown-item to="/usuario" v-if="$root.logged">Mi Cuenta</b-dropdown-item>
                <b-dropdown-item to="/login" v-if="!$root.logged">Iniciar sesión</b-dropdown-item>
                <b-dropdown-item to="/registrarse" v-if="!$root.logged">Registrarse</b-dropdown-item>
              </b-nav-item-dropdown>
              <!-- <b-nav-item to="/mis-favoritos"><i class="far fa-heart"></i></b-nav-item> -->
              <b-nav-item class="nav-item-cart" to="/cart"><i class="fal fa-shopping-cart icon"><span class="num">{{ $root.carritoCount }}</span></i></b-nav-item>
            </b-navbar-nav>
          </b-collapse>
        </div>
      </b-navbar>
      <!--  -->

      <!-- Header menu -->
      <b-navbar toggleable="lg" type="light" variant="light" class="header-menu">
        <div class="container oversized-container">
          <b-navbar-brand to="/">
            <img src="public/images/shared/logo.png">
          </b-navbar-brand>

          <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

          <b-collapse id="nav-collapse" is-nav>
            <b-navbar-nav>
              <b-nav-item to="/">Inicio</b-nav-item>
              <li class="nav-item">
                <a class="nav-link" @click="isActive = !isActive">Productos</a>
              </li>
              <b-nav-item to="/pagos-y-envios">Pagos y envíos</b-nav-item>
              <b-nav-item to="/garantias-confidencialidad">Garantías y confidencialidad</b-nav-item>
              <b-nav-item to="/tiendas">Tiendas</b-nav-item>
              <b-nav-item to="/preguntas-frecuentes">FAQs</b-nav-item>
              <b-nav-item to="/contacto">Contacto</b-nav-item>
            </b-navbar-nav>

            <!-- Right aligned nav items -->
            <b-navbar-nav class="ml-auto">
              <b-nav-form class="search-form" @submit="searchForm">
                <b-form-input size="sm" v-model="search.keywords" placeholder="Buscar productos..."></b-form-input>
                <b-button size="sm" class="btn-search" type="submit">Buscar</b-button>
              </b-nav-form>

              <!-- <b-nav-item-dropdown class="dropdown-color" right>
                <template #button-content>
                  <span>A - Z</span>
                </template>
                <b-dropdown-item to="#">Opción</b-dropdown-item>
              </b-nav-item-dropdown>

              <b-nav-item-dropdown class="dropdown-color" right>
                <template #button-content>
                  <span>Precio</span>
                </template>
                <b-dropdown-item to="#">Opción</b-dropdown-item>
              </b-nav-item-dropdown>

              <b-nav-item-dropdown class="dropdown-color" right>
                <template #button-content>
                  <span>Area</span>
                </template>
                <b-dropdown-item to="#">Opción</b-dropdown-item>
              </b-nav-item-dropdown> -->

              <li class="nav-item nav-sep d-lg-none">
                <a class="nav-link"><hr /></a>
              </li>

              <b-nav-item-dropdown right class="d-lg-none">
                <template #button-content>
                  <span><i class="far fa-user"></i> Mi cuenta</span>
                </template>
                <b-dropdown-item to="/usuario" v-if="$root.logged">Mi Cuenta</b-dropdown-item>
                <b-dropdown-item to="/login" v-if="!$root.logged">Iniciar sesión</b-dropdown-item>
                <b-dropdown-item to="/registrarse" v-if="!$root.logged">Registrarse</b-dropdown-item>
              </b-nav-item-dropdown>

              <!-- <b-nav-item class="d-lg-none" to="/mis-favoritos"><i class="far fa-heart"></i> Favoritos</b-nav-item> -->
              <b-nav-item class="d-lg-none" to="/cart"><i class="fas fa-shopping-cart"></i> Carrito <i class="box-cart-num">{{ $root.carritoCount }}</i></b-nav-item>
            </b-navbar-nav>
          </b-collapse>
        </div>
      </b-navbar>
      <!--  -->

      <!-- Search box -->
      <div class="search-box">
        <div class="container-fluid px-0">
          <b-nav-form class="search-form" @submit="searchForm">
            <b-form-input size="sm" v-model="search.keywords" placeholder="Buscar productos..."></b-form-input>
            <b-button size="sm" class="btn-search" type="submit"><i class="fas fa-search"></i></b-button>
          </b-nav-form>
        </div>
      </div>
      <!--  -->

      <!-- Product menu -->
      <div class="trans-250 products-menu" v-bind:class="{ active: isActive }">
        <div class="menu-bg" @click="toggleMenu(false)"></div>

        <div class="tablist" role="tablist">
          <div class="trans-250 box-title" @click="toggleMenu(false)">
            <h4>PRODUCTOS</h4>
            <!-- <br>
            <h5 v-on:click="$router.push('/productos');">Categorias</h5> -->
            <i class="fas fa-chevron-left icon"></i>
          </div>

          <b-card no-body class="mb-1">
            <b-card-header header-tag="header" role="tab">
              <router-link class="btn-toggle" to="/productos">Ver todos</router-link>
            </b-card-header>
          </b-card>
          <b-card no-body class="mb-1" v-for="(category, pcatIndex) in categories" :key="pcatIndex">
            <b-card-header header-tag="header" role="tab">
              <!-- <router-link class="btn-toggle" v-b-toggle="'accordion-'+pcatIndex">{{ category.name }}</router-link> -->
              <router-link class="btn-toggle" :to="'/categoria/'+category.id">{{ category.name }}</router-link>

            </b-card-header>

            <!-- subcategorias -->
            <!-- <b-collapse :id="'accordion-'+pcatIndex" visible accordion="my-accordion" role="tabpanel" v-if="category.subcategories.length">
              <b-card-body>
                <ul class="ul-sub-options">
                  <li v-for="subcategory in category.subcategories">
                    <router-link class="trans-250" :to="'/subcategoria/'+subcategory.id">{{ subcategory.name }}</router-link>
                  </li>
                </ul>
              </b-card-body>
            </b-collapse> -->
            <!-- fin de subcategorias -->
          </b-card>
        </div>
      </div>
      <!--  -->

    </div>

  </header>
</template>

<script>
export default {
  data(){
    return{
      isActive: false,

      categories:[],
      redes: {
        facebook: '#',
        instagram: '#'
      },

      search: {
        keywords: null
      },
    }
  },

  methods:{
    toggleMenu(bool){
      this.isActive = bool;

      if(!bool){
        this.$parent.isMenuActive = false;
      }
    },

    getCategories: function(){
      axios.get(tools.url('/getCategories')).then((response)=>{
        this.categories = response.data;
      }).catch((error)=>{
        console.log(error);
      })
    },

    getRedes: function(){
      axios.get(tools.url('/redes')).then((response)=>{
        this.redes = response.data;;
      }).catch((error)=>{
        console.log(error);
      })
    },

    searchForm(evt){
      evt.preventDefault();
      // this.$router.push('/productos');
      this.$router.push({path: '/busqueda', query: {keywords:this.search.keywords}});
    },

    countStorage: function(){
      var cart = 0;
      if(localStorage.carrito){
        var carrito = JSON.parse(localStorage.getItem('carrito'));
        this.$root.carritoCount = carrito.length;
      }
    }
  },

  watch: {
    $route (to, from){
      // Ocultar menu cada vez que cambie la ruta
      this.toggleMenu(false);
    }
  },

  mounted(){
    // this.getRedes();
    this.getCategories();
    this.countStorage();
  }
}
</script>
