<template lang="html">
  <div id="blog-article-page">
    <!-- <section class="container oversized-container placed-backg article-image-section" v-bind:style="{ backgroundImage: 'url(public/images/pages/blog/article-1.jpg)' }">
      <div class="title-container">
        <h1 class="article-title">Puntualizando. Se hace entrega de vehículos blindados</h1>
      </div>
    </section> -->

    <section class="container oversized-container content-section">
      <div class="image">
        <img :src="noticia.imageUrl">
      </div>

      <h4 class="title">{{ noticia.title }}</h4>
      <h5 class="mb-1 date">{{ noticia.fecha }}</h5>
      <p v-html="noticia.body"></p>
    </section>

  </div>
</template>

<script>
export default {
  data(){
    return{
      id: null,
      noticia: []
    }
  },

  methods: {
      getNoticia: function(){
        axios.get(tools.url('/noticia/'+this.id)).then(
          ({data}) =>{
            this.noticia = data;
          });
        }
    },

    beforeMount(){
      if(this.$route.params.id){
        this.id = this.$route.params.id;
        this.getNoticia();
      }
    },

    watch: {
      $route (to, from){
        this.id = this.$route.params.id;
        this.getNoticia();
      }
    }
}
</script>
