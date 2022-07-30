<template lang="html">
  <div id="text-page">
    <div class="container">
      <h1 class="mb-2 page-title">AVISO DE PRIVACIDAD</h1>
      <p v-html="content.body"></p>
    </div>
  </div>
</template>

<script>
export default {
  data(){
    return{
      content: '',
    }
  },

  methods: {
    getContent: function(){
      axios.get(tools.url('/privacidad')).then((response)=>{
        this.content = response.data;;
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
