<template lang="html">
  <div class="d-flex account-page">
    <div class="container">

      <div class="row">
        <div class="col-xl-12 main-box">

          <div class="row">
            <div class="col-12 px-2">
              <h1 class="mb-3 page-title">{{ title }}</h1>
            </div>
            <div class="col-lg-4 px-2 col-menu">
              <div class="white-box">
                <div class="box-profile">
                  <div class="d-block mt-4 pb-3">
                    <span class="fa-stack fa-4x user-icon">
                      <i class="fas fa-circle fa-stack-2x"></i>
                      <i class="fas fas fa-user fa-stack-1x fa-inverse"></i>
                    </span>

                    <h5 class="txt-username">Bienvenido!</h5>
                  </div>
                </div>

                <hr />

                <div class="box-menu">
                  <p class="item">
                    <router-link class="btn-menu" to="/usuario"><i class="far fa-edit"></i> Mis datos</router-link>
                  </p>
                  <p class="mb-3 item">
                    <router-link class="btn-menu" to="/usuario/contrasena"><i class="fas fa-lock"></i> Mi contraseña</router-link>
                  </p>

                  <!-- <p class="item">
                    <router-link class="btn-menu" to="/usuario/mis-cotizaciones"><i class="fas fa-tasks"></i> Mis cotizaciones</router-link>
                  </p> -->
                  <!-- <p class="item">
                    <router-link class="btn-menu" to="/usuario/nueva-cotizacion"><i class="fas fa-edit"></i> Nueva cotización</router-link>
                  </p>
                  <p class="item">
                    <router-link class="btn-menu" to="/usuario/mis-cotizaciones"><i class="fas fa-clipboard-list mr-1"></i> Mis cotizaciones</router-link>
                  </p> -->

                  <p class="item">
                    <router-link class="btn-menu" to="/historial-de-compras"><i class="fas fa-history"></i> Historial de compras</router-link>
                  </p>

                  <p class="item">
                    <a class="btn-menu" v-on:click="logout()" style="cursor: pointer;"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a>
                  </p>
                </div>

              </div>
            </div>

            <div class="col-lg px-2">
              <div class="white-box p-3 p-sm-4">

                <router-view></router-view>

              </div>
            </div>
          </div>

        </div>
      </div>

    </div>
  </div>
</template>

<script>
export default {
  data(){
    return{
      title: 'Mi cuenta'
    }
  },

  methods:{
    getUrlName(){
      var urlName = this.$route.path;

      if(urlName == '/usuario'){ this.title = 'Mis datos'; }
      if(urlName == '/usuario/contrasena'){ this.title = 'Cambiar contraseña'; }
    },

    logout(){
        axios.post("api/logout").then((response)=>{
          this.$parent.user = { name:"",
                                password:"",
                                email:"",
                                celphone:"",
                                phone:"",
                                access:"",
                                imageUrl:"",
                                image_id:"",
                                created_at:"",
                                updated_at:"",
                                roles:"",
                              };

          this.$parent.token = "";
          localStorage.removeItem('tokenFront');
          this.$parent.logged = false;
          this.$router.push('/');
        }).catch((error)=>{
          console.log(error);
        });
      }
  },

  beforeMount(){
    this.getUrlName();
    if(!this.$root.logged)
      this.$router.push("/");
  },

  watch: {
    $route(to, from) {
      this.getUrlName();
    },
  }
}
</script>
