<template lang="html">
  <div class="placed-backg" id="about-us-page">
    <div class="bg-image"></div>

    <section class="container oversized-container content-section">
      <div class="row align-items-center">
        <div class="col-lg-6 col-image">

        </div>

        <div class="col-lg-6 col-info">
          <h1 class="page-title">Nosotros</h1>

          <p>
            En Virtual sex shop Gdl Alcalá, somos expertos en ventas en línea, de productos y accesorios para adulto tales como: Lencería, juguetes, preservativos, lubricantes, afrodisiacos, feromonas, bromas y muchos más productos para la sexualidad.
          </p>
          <p class="mt-3">
            Estamos siempre a la vanguardia en el ramo, siempre contamos con las mejores marcas, modelos, novedades y lo mejor de todo es que tenemos los mejores precios en el mercado.
          </p>

          <h2 class="mt-4 page-title">¿Como trabajamos?</h2>
          <p>
            Tenemos alta experiencia en la venta por internet, por mencionar un ejemplo, somos mercado líderes en las mejores páginas de remates como Mercado libre.com, deremate.com, dereto.com entre otras tiendas en línea.
          </p>
          <p class="mt-2">
            Para tu total seguridad cabe mencionar que tenemos un 100% de calificaciones positivas y ninguna falla en dichos portales, esto hace de nuestro servicio el más eficiente del mercado en México.
          </p>
          <p class="mt-2">
            Nos recomendamos a no solo como excelentes en la venta en línea si no también como expertos en el tema de la sexualidad, siempre podrá pedirnos consejos, asesoría , tips todo lo referente a el uso de sus juguetes o cualquier otro tema referente a la sexualidad.
          </p>
          <p class="mt-2">
            Esto lo puede hacer vía electrónica o por los mejores chats en línea como el de el MSN consultando directamente con isaiasalcala@hotmail.com o por el servicio de atención a clientes.
          </p>
          <p class="mt-2">
            Guiamos sus compras vía chat en línea o vía MSN, todas sus dudas o consultas puede hacerlas sin problema alguno, siempre estaremos atentos y con la mejor disposición para atenderlo ya que para nosotros el cliente lo mas importante en este negocio.
          </p>

          <h2 class="mt-4 page-title">Servicios</h2>
          <p>
            En Virtual sex shop Gdl Alcalá contamos con una gran variedad de productos y accesorios como:
          </p>
          <ul class="ul-disclosure">
            <li>Lencería</li>
            <li>Juguetes</li>
            <li>Preservativos</li>
            <li>Lubricantes</li>
            <li>Afrodisiacos</li>
            <li>Feromonas</li>
          </ul>
          <p>
            y muchos más...
          </p>
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
      axios.get(tools.url('/historia')).then((response)=>{
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
