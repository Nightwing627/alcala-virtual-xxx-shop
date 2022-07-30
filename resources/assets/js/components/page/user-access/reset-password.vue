<template lang="html">
  <div id="user-access-page" class="placed-backg">

    <div class="container">
      <div class="row mx-0 flex-center-xy page-size">

        <div class="form-container">
          <div class="box-color"><i><u class="fas fa-user"></u></i></div>

          <b-form class="form" @submit.prevent="recoverPassword()">

            <h1 class="mb-3">Recuperar contraseña</h1>

            <p class="mb-3">
              Escriba su correo electrónico. Le enviaremos un mensaje con los pasos para recuperar su contraseña.
            </p>

            <b-form-group>
              <b-form-input type="email" v-model="form.email" required placeholder="Correo electrónico"></b-form-input>
            </b-form-group>

            <p class="mb-3">
              <router-link to="/login">¿Recuerda su contraseña? ¡Acceder!</router-link>
            </p>

            <b-form-group>
              <b-button type="submit" class="btn-blue" variant="primary">Recuperar contraseña</b-button>
            </b-form-group>

          </b-form>
        </div>

      </div>
    </div>

  </div>
</template>

<script>
export default {
  data(){
    return{
      form: {
        email: '',
        password: ''
      }
    }
  },

  methods: {
    recoverPassword(){
      this.form.email = this.form.email.trim();

      this.$bvToast.toast(`Comprobando correo...`, {
        title: `Recuperar contraseña`,
        toaster: 'b-toaster-bottom-center',
        variant: 'default',
        solid: true,
        appendToast: true
      });

      var data = {correo:this.form.email};
      axios.post(tools.url('/front/recuperarContra'),data).then((response)=>{
          this.$bvToast.toast(`Correo enviado!`, {
            title: `Recuperar contraseña`,
            toaster: 'b-toaster-bottom-center',
            variant: 'success',
            solid: true,
            appendToast: true
          });
          
      }).catch((error)=>{
          this.$bvToast.toast(`Ocurrio un error al enviar el correo`, {
            title: `Recuperar contraseña`,
            toaster: 'b-toaster-bottom-center',
            variant: 'danger',
            solid: true,
            appendToast: true
          });
      });
    }
  }
}
</script>
