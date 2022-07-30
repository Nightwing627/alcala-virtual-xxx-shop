<template lang="html">
  <div id="results-page">

    <section class="banner-section">
      <div class="placed-backg box-banner" v-bind:style="{ backgroundImage: 'url('+ categoryBg +')' }">
        <div class="d-box box-image">
          <img :src="categoryBg">
        </div>
        <div class="d-box">
          <h1>{{ category.name }}</h1>
        </div>
      </div>
      <div class="box-descr" v-if="category.description">
        <div class="container oversized-container" v-html="category.description"></div>
      </div>
    </section>

    <section class="breadcrumb-section">
      <div class="container oversized-container">
        <span>Categoría</span>
        <span class="line">/</span>
        <span>{{ category.name }}</span>
      </div>
    </section>

    <section class="container oversized-container products-section">
      <!-- <div class="row mb-3">
        <div class="col-12">
          <h1 class="category-title">{{ category.name }}</h1>
        </div>
      </div> -->

      <div class="row">
        <!-- Results -->
        <div class="col-lg">
          <div class="row sample-products-wrapper xxl-5e">

            <div class="col-sm-6 col-md-4 col-lg-3 sample-product" v-for="(subcategory, index) in subcategories" :key="index">
              <router-link class="outlined-box" :to="'/subcategoria/'+subcategory.id">
                <div class="box-image">
                  <div class="img">
                    <img :src="subcategory.img">
                  </div>
                </div>

                <div class="box-shot-descr">
                  <h6 class="brand">{{ subcategory.name }}</h6>
                </div>
              </router-link>
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

      category: [],
      category_id:null,
      subcategories: [],
      categoryBg: 'public/images/pages/products/category-bg.jpg',
    }
  },

  methods: {

    getSubcategories: function(category_id){
      axios.get(tools.url('/getSubcategoriesByCategory/'+category_id)).then(({data}) =>{
          this.category = data.category;
          if(this.category.imageUrl){
            this.categoryBg = this.category.imageUrl;
          }
          this.subcategories = data.subcategories;
      });
    },

  },

  watch: {
    "$route.params.id" : function(v){
      this.category_id = this.$route.params.id;
      this.subcategories = [];
      this.getSubcategories(this.category_id);
    },
  },

  mounted(){
    if(this.$route.params.id){
      this.category_id = this.$route.params.id;
      this.getSubcategories(this.category_id);
    }
  },
}
</script>
