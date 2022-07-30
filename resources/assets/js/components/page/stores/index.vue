<template lang="html">
  <div class="placed-backg" id="stores-page">
    <div class="bg-image"></div>

    <section class="container oversized-container content-section">
      <div class="row align-items-center">
        <div class="col-lg-6 col-image">

        </div>

        <div class="col-lg-6 col-info">
          <h1 class="page-title">Tiendas</h1>

          <div class="box-store" v-for="(store, index) in stores" :key="index">
            <h5 class="subtitle-sm">{{ store.name }}</h5>
            <p v-html="store.description"></p>
            <p><a :href="store.facebook"><i class="fab fa-facebook"></i> {{ store.facebook }}</a></p>
          </div>

        </div>
      </div>
    </section>

  </div>
</template>

<script>
export default {
  data(){
    return{
      stores: [],
    }
  },

  methods: {
    getContent: function(){
      axios.get(tools.url('/stores')).then((response)=>{
        this.stores = response.data;
      }).catch((error)=>{
        console.log(error);
      })
    }
  },

  beforeMount(){
    this.getContent();
  }
}
</script>
