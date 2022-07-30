<template lang="html">
  <div class="placed-backg" id="payments-shipments-page">
    <div class="bg-image"></div>

    <section class="container oversized-container content-section">
      <div class="row align-items-center">
        <div class="col-lg-6 col-image">

        </div>

        <div class="col-lg-6 col-info" v-html="content.body">
        </div>
      </div>
    </section>

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
      axios.get(tools.url('/pagos')).then((response)=>{
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
