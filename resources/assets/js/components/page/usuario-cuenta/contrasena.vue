<template lang="html">
  <b-form @submit.prevent="onSubmit()">
    <h4>Contraseña</h4>
    <hr class="c-hr" />

    <b-form-group class="custom-input"
      label="Escriba su actual contraseña:"
      label-for="i-password">
      <b-form-input id="i-password" type="password"
        v-model="form.password" size="sm"
        required placeholder="●●●●●●" />
    </b-form-group>

    <b-form-group class="custom-input"
      label="Escriba su nueva contraseña:"
      label-for="i-npassword">
      <b-form-input id="i-npassword" type="password"
        v-model="form.npassword" size="sm"
        required placeholder="●●●●●●" />
    </b-form-group>

    <b-form-group class="custom-input"
      label="Vuelva a escribir su nueva contraseña:"
      label-for="i-conpassword">
      <b-form-input id="i-conpassword" type="password"
        v-model="form.conpassword" size="sm"
        required placeholder="●●●●●●" />
    </b-form-group>

    <div class="mb-4 form-errors" v-if="formErrors.length">
      <hr/>
      <ul>
        <li class="text-danger" v-for="formError in formErrors">
          <small>{{ formError }}</small>
        </li>
      </ul>
    </div>

    <div class="form-group" v-if="guardado">
      <small class="text-success"> Contraseña actualizada con exito!</small>
    </div>

    <b-button type="submit" class="btn-outline-red">Cambiar contraseña</b-button>

  </b-form>
</template>

<script>
export default {
  data(){
    return{
      guardado: false,
      formErrors: [],
      form: {
        password: '',
        npassword: '',
        conpassword: ''
      }
    }
  },

  methods: {
    onSubmit(){
      this.formErrors = [];
      this.guardado = false;
      if(this.form.npassword < 6)
        this.formErrors.push("La contraseña debe de tener minimo 6 caracteres");
      else if(this.form.npassword != this.form.conpassword)
        this.formErrors.push("La contraseñas no coincide");
      else
        axios.post(tools.url('/front/usuario/cambiarContra'),this.form).then((response)=>{
          if(response.data.status == 200)
            this.guardado = true;
          else
            this.formErrors.push("La contraseña actual es incorrecta");
        }).catch((error)=>{
          console.log(error);
        });
    }
  }
}
</script>
