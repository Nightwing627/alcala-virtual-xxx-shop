<template lang="html">
  <div id="user-access-page" class="placed-backg">

    <div class="container">
      <div class="row mx-0 flex-center-xy page-size">

        <div class="form-container">
          <div class="box-color"><i><u class="fas fa-user"></u></i></div>

          <b-form class="form" @submit="register">

            <h1 class="mb-3">Registrarse</h1>

            <div class="mb-4 form-errors" v-if="formErrors.length">
              <hr />
              <ul>
                <li class="text-danger" v-for="formError in formErrors">
                  <small>{{ formError }}</small>
                </li>
              </ul>
            </div>

            <b-form-group>
              <b-form-input type="text" v-model="form.name" equired placeholder="Nombres"></b-form-input>
            </b-form-group>

            <b-form-group>
              <b-form-input type="text" v-model="form.lastname" equired placeholder="Apellidos"></b-form-input>
            </b-form-group>

            <b-form-group>
              <b-form-input type="email" v-model="form.email" required placeholder="Correo electrónico"></b-form-input>
            </b-form-group>

            <b-form-group>
              <b-form-input type="password" v-model="form.password" required placeholder="Contraseña"></b-form-input>
            </b-form-group>

            <b-form-group>
              <b-form-input type="password" v-model="form.passwordcon" required placeholder="Confirmar contraseña"></b-form-input>
            </b-form-group>

            <div class="d-inline-block mb-3">
              <b-form-checkbox v-model="form.tos" name="usertype" value="1" unchecked-value="" required>
                Acepto los términos y condiciones
              </b-form-checkbox>
            </div>

            <p class="mb-1">
              <router-link to="/login">¿Ya tiene una cuenta?</router-link>
            </p>

            <b-form-group class="mt-3">
              <b-button type="submit" class="btn-blue" variant="primary">Crear una cuenta</b-button>
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
        name: '',
        lastname: '',
        email: '',
        password: '',
        passwordcon: ''
      }
    }
  },

  methods: {
    register(evt){
      evt.preventDefault();
      this.formErrors = [];

      if(this.form.password.length < 6){
        this.formErrors.push("La contraseña debe tener por lo menos 6 caracteres");
      }
      else {
        if(this.form.password !== this.form.passwordcon){
          this.formErrors.push("Los campos contraseña y confirmación de contraseña deben coincidir");
        }
        else {
          axios.post(tools.url('/front/usuario/nuevo'),this.form).then((response)=>{
            if(response.data.status == 200)
            {
              this.$parent.user = response.data.user;
              this.$parent.token = response.data.token;
              localStorage.setItem("tokenFront",this.$parent.token);
              this.$parent.logged = true;
              this.$router.push("/usuario");
            }
            else
              this.formErrors.push(response.data.msg);
          }).catch((error)=>{
            console.log(error);
          });
        }
      }
    }
  },

  mounted()
  {
    if(this.$root.logged)
      this.$router.push("/usuario");
  }
}
</script>
