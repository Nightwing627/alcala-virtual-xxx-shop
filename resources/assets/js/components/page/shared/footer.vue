<template lang="html">
  <footer id="footer">
    <div class="container oversized-container">
      <div class="row">
        <div class="col-12 col-title">
          <router-link to="/">
            <img src="public/images/shared/logo.png">
          </router-link>
        </div>
      </div>

      <div class="row row-menu">
        <div class="col-4 col-md-3 col-lg col-page">
          <router-link to="/nosotros">
            Algo Sobre
            <span>Nosotros</span>
          </router-link>
        </div>

        <div class="col-4 col-md-3 col-lg col-page">
          <router-link to="/cart">
            Revisar
            <span>Mi Pedido</span>
          </router-link>
        </div>

        <div class="col-4 col-md-3 col-lg col-page">
          <router-link to="/login">
            Ingresar A
            <span>Mi Cuenta</span>
          </router-link>
        </div>

        <div class="col-4 col-md-3 col-lg col-page">
          <router-link to="">
            Visitar
            <span>Videochat</span>
          </router-link>
        </div>

        <div class="col-4 col-md-3 col-lg col-page">
          <router-link to="/pagos-y-envios">
            Sobre
            <span>Pagos y Envíos</span>
          </router-link>
        </div>

        <div class="col-4 col-md-3 col-lg col-page">
          <router-link to="/contacto">
            Ponte En
            <span>Contacto</span>
          </router-link>
        </div>
      </div>
    </div>
  </footer>
</template>

<script>
export default {
  data(){
    return{
      redes: {
        telefono: '',
        email: '',
        facebook: '#',
        instagram: '#',
        address: 'Av. Diamante 2680.<br />Col. Bosques de la Victoria<br />Guadalajara, Jal.'
      }
    }
  },

  methods:{

    getRedes: function(){
      axios.get(tools.url('/redes')).then((response)=>{
        this.redes = response.data;;
      }).catch((error)=>{
        console.log(error);
      })
    }

  },

  beforeMount(){
    this.getRedes();
  }
}
</script>
