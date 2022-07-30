<template lang="html">
  <div id="results-page">

    <section class="breadcrumb-section">
      <div class="container oversized-container">
        <span>Productos</span>
        <span class="line">/</span>
        <span>Todos</span>
      </div>
    </section>

    <section class="container oversized-container products-section">
      <div class="row mb-3">
        <div class="col-12">
          <h1 class="category-title">Productos</h1>
        </div>
      </div>

      <div class="row">
        <!-- Btn filtros -->
        <!-- <div class="col-12 col-filters-mobile">
          <div class="bg-filter-mv" v-if="showFilters == true" @click="showFilters = false"></div>
          <a class="btn-filters" @click="showFilters = !showFilters">
            <i class="fas fa-filter"></i><span>Ver filtros</span>
          </a>
        </div> -->
        <!--  -->

        <!-- Filtros -->
        <!-- <div class="col-lg col-filters" v-bind:class="{ 'show-filters': showFilters == true }">
          <h4 class="_title">
            <span>Filtros de Búsqueda</span>
            <a class="btn-hide" @click="showFilters = false"><i class="fas fa-chevron-left"></i></a>
          </h4>

          <b-form class="filters-container" @submit="onSubmit">
            <div class="box-filters">
              <a class="btn-action"><i class="sy">-</i> Categorias</a>
              <div class="box-filters-group">
                <b-form-checkbox class="c-filter-checkbox" v-model="filters.category_id" name="checkbox-0" :value="null" unchecked-value="">Todos</b-form-checkbox>
                <b-form-checkbox class="c-filter-checkbox" v-for="(category, index) in categories" :key="category.id" v-model="filters.category_id" :name="'checkbox-'+index+1" :value="category.id" unchecked-value="">{{ category.name }}</b-form-checkbox>
              </div>
            </div>

            <div class="box-filters">
              <a class="btn-action"><i class="sy">-</i> Precios</a>

              <div class="box-filters-group">
                <b-form-checkbox
                  class="c-filter-checkbox"
                  v-model="filters.precios"
                  name="checkbox-4"
                  :value="null" unchecked-value="">
                  Todos
                </b-form-checkbox>

                <b-form-checkbox
                  class="c-filter-checkbox"
                  v-model="filters.precios"
                  name="checkbox-5"
                  value="1" unchecked-value="">
                  $0 - $900
                </b-form-checkbox>

                <b-form-checkbox
                  class="c-filter-checkbox"
                  v-model="filters.precios"
                  name="checkbox-6"
                  value="2" unchecked-value="">
                  $901 - $1,900
                </b-form-checkbox>

                <b-form-checkbox
                  class="c-filter-checkbox"
                  v-model="filters.precios"
                  name="checkbox-7"
                  value="3" unchecked-value="">
                  $1,901 - $3,000
                </b-form-checkbox>

                <b-form-checkbox
                  class="c-filter-checkbox"
                  v-model="filters.precios"
                  name="checkbox-8"
                  value="4" unchecked-value="">
                  $3,001 - $4,000
                </b-form-checkbox>

                <b-form-checkbox
                  class="c-filter-checkbox"
                  v-model="filters.precios"
                  name="checkbox-9"
                  value="5" unchecked-value="">
                  $4,001 - $5,000
                </b-form-checkbox>
              </div>
            </div>
          </b-form>
        </div> -->
        <!--  -->

        <!-- Results -->
        <div class="col-lg">
          <div class="row sample-products-wrapper xxl-5e">
            <div class="col-sm-6 col-md-4 col-lg-3 sample-product" v-for="product in products">
              <router-link class="outlined-box" :to="'/producto/'+product.id">
                <div class="box-image">
                  <div class="img">
                    <img :src="product.img">
                  </div>
                </div>

                <div class="box-shot-descr">
                  <h6 class="brand" v-if="product.stock < 1">AGOTADO</h6>
                  <h6 class="brand">{{ product.sku }}</h6>
                  <h6 class="name">{{ product.name }}</h6>
                  <h6 class="price">${{ product.price }}</h6>

                  <p class="descr" v-html="product.description"></p>
                </div>
              </router-link>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12 col-pagination" v-if="products.length">
              <b-pagination v-model="pagination.current_page" :total-rows="pagination.total" :per-page="50" last-number></b-pagination>
            </div>

            <div class="col-md-12 my-5">
              <h5 class="text-center" v-if="!products.length">
                {{ loadingText }}
              </h5>
            </div>
          </div>

        </div>
        <!--  -->

      </div>
    </section>

  </div>
</template>

<script>
export default {
  data(){
    return{
      showFilters: false,

      filters: {
        keywords: '',
        precio: null,
        category_id: null,
      },

      products: [],
      categories: [],
      loadingText: 'Cargando...',
      loading: true,
      pagination : { 'total' : 0, 'current_page' : 1}
    }
  },

  methods: {
    onSubmit() {
      console.log('Buscando...');
      this.getResults();
    },

    getProducts: function(){
      axios.get(tools.url('/productos?page=' + this.pagination.current_page)).then((response)=>{
        this.products = response.data.data;
        this.pagination.total = response.data.total;
        if(!this.products.legth){
          this.loadingText = 'No se encontraron resultados';
        }
        setTimeout( ()=> { this.loading = false; }, 500);

      }).catch((error)=>{
        console.log(error);
      })
    },

    getCategories: function(){
      axios.get(tools.url('/getCategories')).then((response)=>{
        this.categories = response.data;
      }).catch((error)=>{
        console.log(error);
      })
    },

     getResults(){
        this.loading = true;
        axios.post(tools.url('/productos/search?page=' + this.pagination.current_page), this.filters).then((response)=>{
          this.products = response.data.data;
          this.pagination.total = response.data.total;
          if(!this.products.legth){
            this.loadingText = 'No se encontraron resultados';
          }
          setTimeout( ()=> { this.loading = false; }, 500);

        }).catch((error)=>{
          console.log(error);
        });
    },

    linkGen(pageNum) {
      return pageNum === 1 ? '?' : `?page=${pageNum}`
    },
  },

  watch: {
    filters: {
      deep: true,

      handler(val, oldVal){
        this.onSubmit();
      }
    },

    '$route.query.keywords':function()
    {
      this.filters.keywords = this.$route.query.keywords;
      this.getResults();
    },
    "pagination.current_page" : function(v){
      this.getProducts();
    },
  },

  mounted(){
    //this.getCategories();

    if(this.$route.query.keywords){
      this.filters.keywords = this.$route.query.keywords;
      this.getResults();
    }else{
      this.getProducts();
    }
  },
}
</script>
