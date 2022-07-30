<template lang="html">
  <b-form @submit.prevent="onSubmit()">
    <h4>Datos de personales</h4>
    <hr class="c-hr" />

    <b-form-group class="custom-input" label="Nombre completo:" label-for="i-nombre">
      <b-form-input id="i-nombre" type="text" v-model="$root.user.name" size="sm" required placeholder="Escriba su nombre" />
    </b-form-group>

     <b-form-group class="custom-input" label="Apellidos:" label-for="i-lastname">
      <b-form-input id="i-lastname" type="text" v-model="$root.user.lastname" size="sm" required placeholder="Escriba sus apellidos" />
    </b-form-group>

    <b-form-group class="custom-input" label="Correo electrónico:" label-for="i-email">
      <b-form-input id="i-email" type="email" v-model="$root.user.email" size="sm" required placeholder="Escriba correo electrónico" />
    </b-form-group>

    <b-form-group class="custom-input" label="Teléfono:" label-for="i-tel">
      <b-form-input id="i-tel" type="text" v-model="$root.user.phone" size="sm" required placeholder="Escriba su teléfono" maxlength="10"/>
    </b-form-group>

    <h5 class="mt-5">Dirección</h5>
    <hr class="c-hr" />

    <div class="row mx-0 no-gutters">
      <div class="col-md-7 col-lg-6">
        <b-form-group class="custom-input" label="Calle:" label-for="i-calle">
          <b-form-input id="i-calle" type="text" v-model="$root.user.customer.street" size="sm" required placeholder="Calle donde vive" />
        </b-form-group>
      </div>
      <div class="col-md pl-md-3">
        <b-form-group class="custom-input" label="Numero ext:" label-for="i-num">
          <b-form-input id="i-numext" type="text" v-model="$root.user.customer.num_ext" size="sm" required placeholder="0000" />
        </b-form-group>
      </div>

      <div class="col-md pl-md-3">
        <b-form-group class="custom-input" label="Numero int:" label-for="i-num">
          <b-form-input id="i-numint" type="text" v-model="$root.user.customer.num_int" size="sm" placeholder="0000" />
        </b-form-group>
      </div>
    </div>

    <div class="row mx-0 no-gutters">
      <div class="col-md-8">
        <b-form-group class="custom-input" label="Colonia:" label-for="i-colonia">
          <b-form-input id="i-colonia" type="text" v-model="$root.user.customer.neighborhood" size="sm" required placeholder="Escriba su colonia" />
        </b-form-group>
      </div>

      <div class="col-md pl-md-3">
        <b-form-group class="custom-input" label="Código postal:" label-for="i-cp">
          <b-form-input id="i-cp" type="text" v-model="$root.user.customer.postalCode" size="sm" required placeholder="Escriba su código postal" />
        </b-form-group>
      </div>
    </div>


    <div class="row mx-0 no-gutters">
      <div class="col-md-6 pr-md-3">
        <b-form-group class="custom-input" label="Estado:" label-for="i-estado">
          <v-select v-model="$root.user.customer.state_id" :options="estados" label="name" index="id" @change="getCiudades"/>
        </b-form-group>
      </div>

      <div class="col-md-6">
        <b-form-group class="custom-input" label="Ciudad:" label-for="i-ciudad">
          <v-select v-model="$root.user.customer.town_id" :options="ciudades" label="name" index="id"/>
        </b-form-group>
      </div>
    </div>

    <!-- <div class="form-group" v-if="guardado">
      <small class="text-success"> Cambios guardados con exito!</small>
    </div> -->

    <sweet-modal :icon="modal.icon" :blocking="modal.block" :hide-close-button="modal.block" ref="modal">
      <img src="public/images/spinner.gif" alt="" v-if="modal.icon== ''"><br>
      {{modal.msg}}
      <div class="col-12 text-center" style="padding-top: 20px;" v-if="modal.icon == 'success'">
        <b-button class="btn btn-primary" slot="button" v-on:click.prevent="$refs.modal.close();">OK</b-button>
      </div>
    </sweet-modal>

    <b-button type="submit" class="btn-outline-red">Guardar cambios</b-button>

  </b-form>

</template>

<script>
export default {
  data(){
    return{
      estados: [],
      ciudades: [],
      guardado: false,
      blockNull:false,

       modal:{
          msg:'',
          icon:'',
          block:false,
          carrito:true
        },
}
  },

  watch:{
    '$root.user.customer.state_id':function(val)
    {
      if(val && !isNaN(val))
      {
        this.getCiudades(val);
      }
    }
  },

  methods: {

    getEstados(){
      axios.get(tools.url('/estados')).then((response)=>{
        this.estados = response.data;
      }).catch((error)=>{
         console.log(error);
      });
    },

    getCiudades(state_id){
      axios.get(tools.url('/ciudades/' + state_id)).then((response)=>{
        this.ciudades = response.data;
      }).catch((error)=>{
        console.log(error);
      }); 
    },

    onSubmit(){
      this.modal.block = true;
      this.modal.icon = '';
      this.modal.msg = 'Guardando, por favor espere...';
      this.$refs.modal.open();

      var data = {
        id: this.$root.user.id,
        name: this.$root.user.name,
        lastname: this.$root.user.lastname,
        email: this.$root.user.email,
        phone: this.$root.user.phone,
        //customer
        street: this.$root.user.customer.street,
        num_int: this.$root.user.customer.num_int,
        num_ext: this.$root.user.customer.num_ext,
        neighborhood: this.$root.user.customer.neighborhood,
        postalCode: this.$root.user.customer.postalCode,
        state_id: this.$root.user.customer.state_id,
        town_id: this.$root.user.customer.town_id,
      };
      
      this.formErrors = [];
      this.guardado = false;

      axios.post(tools.url('/front/usuario/guardarCambios'),data).then((response)=>{
        if(response.data.status == 200){
          this.modal.icon = "success";
          this.modal.msg = response.data.msg;
          this.modal.block = true;
          this.guardado = true;
        }
        else
            this.formErrors.push("El correo que colocó ya esta en uso");
      }).catch((error)=>{
        console.log(error);
        this.formErrors.push("Ocurrio un error al guardar los cambios");
      });
    }

  },

  beforeMount(){
    this.getEstados();
  },

  mounted(){
    if(this.$root.user.customer.state_id){
      this.getCiudades(this.$root.user.customer.state_id);
    }
  }
}
</script>
