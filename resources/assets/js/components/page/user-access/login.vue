<template lang="html">
  <div id="user-access-page" class="placed-backg">

    <div class="container">
      <div class="row mx-0 flex-center-xy page-size">

        <div class="form-container">
          <div class="box-color"><i><u class="fas fa-user"></u></i></div>

          <b-form class="form" @submit.prevent="login">

            <h1 class="mb-3">Iniciar Sesión</h1>

            <div class="mb-4 form-errors" v-if="formErrors.length">
              <hr />
              <ul>
                <li class="text-danger" v-for="formError in formErrors">
                  <small>{{ formError }}</small>
                </li>
              </ul>
            </div>

            <b-form-group>
              <b-form-input type="email" v-model="form.email" required placeholder="Correo electrónico"></b-form-input>
            </b-form-group>

            <b-form-group>
              <b-form-input type="password" v-model="form.password" required placeholder="Contraseña"></b-form-input>
            </b-form-group>

            <p class="mb-3">
              <router-link to="/recuperar-contrasena">¿Olvidó su contraseña?</router-link>
            </p>

            <b-form-group>
              <b-button type="submit" class="btn-blue" variant="primary">Acceder</b-button>
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
      formErrors: [],

      form: {
        email: '',
        password: ''
      }
    }
  },

  watch: {
    '$parent.logged' (val){
      console.log(val);
      if(val){ this.$router.push("/usuario"); }
    }
  },

  methods: {
    login(){
      this.formErrors = [];

      axios.post(tools.url('/api/login'),this.form).then((response)=>{
        this.$parent.user = response.data.user;
        this.$parent.token = response.data.token;
        localStorage.setItem("tokenFront",this.$parent.token);
        this.$parent.logged = true;
        window.axios.defaults.headers.common['Authorization'] = response.data.token;
        this.$router.push("/usuario");
        
      }).catch((error)=>{
          this.formErrors.push("Credenciales incorrectas");
      });
    }
  },

  mounted()
  {
    if(this.$root.logged)
      this.$router.push("/usuario");
  }
}
</script>
