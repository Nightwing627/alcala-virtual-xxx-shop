<template lang="html">
  <div id="blog-page">

    <div class="container content">
      <div class="row">
        <div class="col-12 col-title">
          <h1 class="title">BLOG</h1>
        </div>
      </div>
      <div class="row">

        <div class="col-md-6 col-lg-4 col-article" v-for="(noticia, index) in blog">
          <router-link class="box" :to="'blog/' + noticia.id">
            <div class="placed-backg box-image" v-bind:style="{ backgroundImage: 'url(' + noticia.imageUrl + ')' }"></div>

            <div class="box-text">
              <h6 class="date">{{ noticia.fecha }}</h6>
              <h5 class="title">{{ noticia.title }}</h5>

              <div class="short-descr" v-html="noticia.body"></div>

              <p class="mt-2 text-right">
                <router-link class="_link" :to="'blog/' + noticia.id">Ver artículo</router-link>
              </p>
            </div>
          </router-link>
        </div>

      </div>
    </div>

  </div>
</template>

<script>
export default {
  data(){
    return{
      blog: [],
    }
  },

  methods: {
      getNoticias: function(){
        axios.get(tools.url('/noticias')).then(
          ({data}) =>{
            this.blog = data;
          });
        }
    },

    mounted(){
      this.getNoticias();
    }
}
</script>
