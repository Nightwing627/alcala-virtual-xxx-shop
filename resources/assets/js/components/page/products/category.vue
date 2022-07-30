<template lang="html">
  <div id="results-page">

    <section class="breadcrumb-section">
      <div class="container oversized-container">
        <span>Categorías</span>
        <span class="line">/</span>
        <span>{{ category.name }}</span>
      </div>
    </section>

    <section class="container oversized-container products-section">
      <div class="row mb-3">
        <div class="col-12">
          <h1 class="category-title">{{ category.name }}</h1>
        </div>
      </div>

      <div class="row">
        <!-- Btn filtros -->
        <div class="col-12 col-filters-mobile">
          <div class="bg-filter-mv" v-if="showFilters == true" @click="showFilters = false"></div>
          <a class="btn-filters" @click="showFilters = !showFilters">
            <i class="fas fa-filter"></i><span>Ver filtros</span>
          </a>
        </div>
        <!--  -->

        <!-- Filtros -->
        <div class="col-lg col-filters" v-bind:class="{ 'show-filters': showFilters == true }">
          <h4 class="_title">
            <span>Filtros de Búsqueda</span>
            <a class="btn-hide" @click="showFilters = false"><i class="fas fa-chevron-left"></i></a>
          </h4>

          <b-form class="filters-container" @submit="onSubmit">
            <!-- Acabado -->
            <!-- <div class="box-filters">
              <a class="btn-action"><i class="sy">-</i> Material</a>

              <div class="box-filters-group">
                <b-form-checkbox
                  class="c-filter-checkbox"
                  v-model="filtersForm.material"
                  name="checkbox-1"
                  :value="null" unchecked-value="">
                  Todos
                </b-form-checkbox>

                <b-form-checkbox
                  class="c-filter-checkbox"
                  v-model="filtersForm.material"
                  name="checkbox-2"
                  value="1" unchecked-value="">
                  Teflón
                </b-form-checkbox>

                <b-form-checkbox
                  class="c-filter-checkbox"
                  v-model="filtersForm.material"
                  name="checkbox-3"
                  value="2" unchecked-value="">
                  Acero Inoxidable
                </b-form-checkbox>
              </div>
            </div> -->
            <!--  -->

            <!-- <div class="box-filters">
              <a class="btn-action"><i class="sy">-</i> Categorias</a>
              <div class="box-filters-group">
                <b-form-checkbox class="c-filter-checkbox" v-model="filtersForm.category_id" name="checkbox-0" :value="null" unchecked-value="">Todos</b-form-checkbox>
                <b-form-checkbox class="c-filter-checkbox" v-for="(category, index) in categories" :key="category.id" v-model="filtersForm.category_id" :name="'checkbox-'+index+1" :value="category.id" unchecked-value="">{{ category.name }}</b-form-checkbox>
              </div>
            </div> -->

            <!-- Color -->
            <div class="box-filters">
              <a class="btn-action"><i class="sy">-</i> Precios</a>

              <div class="box-filters-group">
                <b-form-checkbox
                  class="c-filter-checkbox"
                  v-model="filtersForm.precios"
                  name="checkbox-4"
                  :value="null" unchecked-value="">
                  Todos
                </b-form-checkbox>

                <b-form-checkbox
                  class="c-filter-checkbox"
                  v-model="filtersForm.precios"
                  name="checkbox-5"
                  value="1" unchecked-value="">
                  $0 - $900
                </b-form-checkbox>

                <b-form-checkbox
                  class="c-filter-checkbox"
                  v-model="filtersForm.precios"
                  name="checkbox-6"
                  value="2" unchecked-value="">
                  $901 - $1,900
                </b-form-checkbox>

                <b-form-checkbox
                  class="c-filter-checkbox"
                  v-model="filtersForm.precios"
                  name="checkbox-7"
                  value="3" unchecked-value="">
                  $1,901 - $3,000
                </b-form-checkbox>

                <b-form-checkbox
                  class="c-filter-checkbox"
                  v-model="filtersForm.precios"
                  name="checkbox-8"
                  value="4" unchecked-value="">
                  $3,001 - $4,000
                </b-form-checkbox>

                <b-form-checkbox
                  class="c-filter-checkbox"
                  v-model="filtersForm.precios"
                  name="checkbox-9"
                  value="5" unchecked-value="">
                  $4,001 - $5,000
                </b-form-checkbox>
              </div>
            </div>
            <!--  -->

            <!-- Tipo -->
            <!-- <div class="box-filters">
              <a class="btn-action"><i class="sy">-</i> Color</a>

              <div class="box-filters-group">
                <b-form-checkbox
                  class="c-filter-checkbox"
                  v-model="filtersForm.color"
                  name="checkbox-11"
                  :value="null" unchecked-value="">
                  Todos
                </b-form-checkbox>

                <b-form-checkbox
                  class="c-filter-checkbox"
                  v-model="filtersForm.color"
                  name="checkbox-12"
                  value="1" unchecked-value="">
                  Negro
                </b-form-checkbox>

                <b-form-checkbox
                  class="c-filter-checkbox"
                  v-model="filtersForm.color"
                  name="checkbox-13"
                  value="2" unchecked-value="">
                  Rojo
                </b-form-checkbox>

                <b-form-checkbox
                  class="c-filter-checkbox"
                  v-model="filtersForm.color"
                  name="checkbox-14"
                  value="3" unchecked-value="">
                  Verde
                </b-form-checkbox>
              </div>
            </div> -->
            <!--  -->

            <!-- Precio -->
            <!-- <div class="box-filters">
              <a class="btn-action"><i class="sy">-</i> Precio</a>

              <div class="box-filters-group">
                <b-form-select class="c-filter-select" v-model="filtersForm.precio">
                  <b-form-select-option :value="null">Seleccione un precio</b-form-select-option>
                  <b-form-select-option value="a">$800 o menos</b-form-select-option>
                  <b-form-select-option value="b">$1499 o menos</b-form-select-option>
                  <b-form-select-option value="c">$1500 o más</b-form-select-option>
                </b-form-select>
              </div>
            </div> -->
            <!--  -->

          </b-form>
        </div>
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
                  <h6 class="brand">{{ product.sku }}</h6>
                  <h6 class="name">{{ product.name }}</h6>
                  <h6 class="price">${{ product.price }}</h6>

                  <p class="descr">
                    
                  </p>
                </div>
              </router-link>
            </div>
            <h5 v-if="!products.length">No se encontraron resultados</h5>
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

      filtersForm: {
        precios: null,
        category_id: null,
      },

      category: [],
      category_id:null,
      products: [],
    }
  },

  methods: {
    onSubmit() {
      console.log('Buscando...');
      this.getResults();
    },

    getProductsCategory: function(category_id){
      axios.get(tools.url('/productos/subcategory/'+category_id)).then(
        ({data}) =>{
          this.products = data.products;
          this.category = data.category;
        });
    },

    getCategories: function(){
      axios.get(tools.url('/getCategories')).then((response)=>{
        this.categories = response.data;
      }).catch((error)=>{
        console.log(error);
      })
    },

    getResults(){
      axios.post(tools.url('/productos/subcategory/'+this.category_id), this.filtersForm).then((response)=>{
        this.products = [];
        this.products = response.data.products;
        this.category = response.data.category;
      }).catch((error)=>{
        console.log(error);
      });
    }

  },

  watch: {
    filtersForm: {
      deep: true,

      handler(val, oldVal){
        this.onSubmit();
      }
    },

    "$route.params.id" : function(v){
      this.category_id = this.$route.params.id;
      this.products=[];
      this.getProductsCategory(this.category_id);
    },

    "filtersForm.category_id" : function(v){
      this.products=[];
      this.getProductsCategory(this.category_id);
    },
  },

  mounted(){
    this.getCategories();

    if(this.$route.params.id){
      this.category_id = this.$route.params.id;
      this.filtersForm.category_id = this.category_id;
      this.getProductsCategory(this.category_id);
    }
  },
}
</script>
