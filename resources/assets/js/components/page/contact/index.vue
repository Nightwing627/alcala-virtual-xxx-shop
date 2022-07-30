<template lang="html">
  <div class="placed-backg" id="contact-page">
    <div class="bg-image"></div>

    <section class="container oversized-container content-section">
      <div class="row align-items-center">
        <div class="col-lg-6 col-image">

        </div>

        <div class="col-lg-4 offset-lg-1 col-info">
          <h1 class="page-title">Contacto</h1>

          <b-form @submit="onSubmit">
            <b-form-group>
              <b-form-input
                v-model="form.name"
                type="text"
                required
                placeholder="Nombre"
              ></b-form-input>
            </b-form-group>

            <b-form-group>
              <b-form-input
                v-model="form.email"
                type="email"
                required
                placeholder="Correo electrónico"
              ></b-form-input>
            </b-form-group>

            <b-form-group>
              <b-form-input
                v-model="form.phone"
                type="text"
                required
                placeholder="Teléfono"
              ></b-form-input>
            </b-form-group>

            <b-form-group>
              <b-form-textarea
                v-model="form.msg"
                placeholder="Mensaje"
                required
                rows="3"
                max-rows="6"
              ></b-form-textarea>
            </b-form-group>

            <p class="text-center">
              <b-button type="submit" class="btn-send">Enviar</b-button>
            </p>
          </b-form>

        </div>
      </div>
    </section>

  </div>
</template>

<script>
export default {
  data(){
    return{
      form: {
        name: null,
        email: null,
        phone: null,
        msg: null
      },
      redes: [],
    }
  },

  methods: {
    makeToast(variant = null, msg, title) {
      this.$bvToast.toast(msg, {
        title: title,
        variant: variant,
        solid: true,
        toaster: 'b-toaster-top-right',
        appendToast: true
      })
    },

    getRedes: function(){
      axios.get(tools.url('/redes')).then((response)=>{
        this.redes = response.data;;
      }).catch((error)=>{
        console.log(error);
      })
    },

    onSubmit(evt) {
      evt.preventDefault();
      //var data=tools.params(form, this.form);
      axios.post(tools.url("/contacto"), this.form).then((response)=>{
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
  },

  beforeMount(){
    this.getRedes();

    if(this.$route.query.p){
      this.form.msg = 'Me intresa el producto '+ this.$route.query.p;
    }
  }
}
</script>
