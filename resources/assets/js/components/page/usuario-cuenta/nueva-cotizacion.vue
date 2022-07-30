<template lang="html">
  <b-form @submit="onSubmit">

    <!-- Paso 1 -->
    <div class="box-quotation" v-if="currentStep == 1">
      <h5>Nueva cotización</h5>
      <hr class="c-hr" />

      <b-form-group class="custom-input"
        label="Nombre completo:"
        label-for="i-nombre">
        <b-form-input id="i-nombre" type="text"
          v-model="form.nombre" size="sm"
          required placeholder="Escriba su nombre completo" />
      </b-form-group>

      <b-form-group class="custom-input"
        label="Correo electrónico:"
        label-for="i-email">
        <b-form-input id="i-email" type="email"
          v-model="form.email" size="sm"
          required placeholder="Escriba correo electrónico" />
      </b-form-group>

      <b-form-group class="custom-input"
        label="Título de la Cotización:"
        label-for="i-coti">
        <b-form-input id="i-coti" type="text"
          v-model="form.tel" size="sm"
          required placeholder="Escriba un título" />
      </b-form-group>

      <p class="text-center text-md-right">
        <b-button type="submit" class="b-alter">SIGUIENTE</b-button>
      </p>
    </div>
    <!--  -->

    <!-- Paso 2 -->
    <div class="box-quotation" v-if="currentStep == 2">
      <h5>Agregar Partidas</h5>
      <hr class="c-hr" />

      <b-form-group class="custom-input group-product-s"
        label="Agregar productos:"
        label-for="i-search">
        <b-form-input id="i-search" type="text"
          v-model="keywords" size="sm"
          placeholder="Escriba el producto a buscar" />
        <div class="trans-250 btn-psearch" @click="searchProds()">Buscar</div>
      </b-form-group>

      <!-- Productos agregados -->
      <div class="pt-4 box-quotation_added-products">
        <h6 class="box-title">Productos Agregados</h6>
        <div class="b-product" v-for="(s, iReIdx) in 3">
          <div class="col-md-3 col-img">
            <img src="public/images/pages/products/product-1.jpg">
          </div>
          <div class="col col-lg col-text">
            <p>
              Adaptador bridado sin fondo
            </p>
          </div>
          <div class="col col-lg col-btns">
            <div class="d-box">
              <div class="_btn">+</div>
              <div class="num">1</div>
              <div class="_btn">-</div>

              <a class="btn-add btn-red">QUITAR</a>
            </div>
          </div>
        </div>
      </div>
      <!--  -->

      <p class="text-center text-md-right mt-4">
        <a class="btn btn-secondary b-alter" @click="goBack">ANTERIOR</a>
        <b-button type="submit" class="b-alter">SIGUIENTE</b-button>
      </p>
    </div>
    <!--  -->

    <!-- Paso 3 -->
    <div class="box-quotation" v-if="currentStep == 3">
      <h5>Especificaciones</h5>
      <hr class="c-hr" />

      <b-form-group class="custom-input"
        label-for="i-espec">
        <b-form-textarea
          id="i-espec"
          v-model="form.espec"
          size="sm"
          placeholder="Ingrese aquí las especificaciones de los productos"
          rows="8"
          max-rows="8"
          required
        ></b-form-textarea>
      </b-form-group>

      <p class="text-center text-md-right mt-4">
        <a class="btn btn-secondary b-alter" @click="goBack">ANTERIOR</a>
        <b-button type="submit" class="b-alter">SIGUIENTE</b-button>
      </p>
    </div>
    <!--  -->

    <!-- Paso 4 -->
    <div class="box-quotation" v-if="currentStep == 4">
      <h5>Resumen de la Cotización</h5>
      <hr class="c-hr" />

      <div class="d-block mt-4">
        <h6 class="text-center f-w-600">Datos del cliente</h6>
        <hr class="mt-1" />

        <p>
          Cliente: <strong>Jesus Torres</strong>
        </p>
        <p>
          Empresa: <strong>SUSTAM S.A. DE C.V.</strong>
        </p>
        <p>
          Correo electrónico: <strong>correo@sustam.com</strong>
        </p>
        <p>
          Teléfono: <strong>33 4000 0100</strong>
        </p>
      </div>

      <div class="d-block position-relative mt-4">
        <h6 class="text-center f-w-600">Productos a cotizar</h6>
        <hr class="mt-1" />

        <!-- Productos agregados -->
        <div class="box-quotation_added-products">
          <div class="b-product" v-for="(s, iReIdx) in 3">
            <div class="col-md-3 col-img">
              <img src="public/images/pages/products/product-1.jpg">
            </div>
            <div class="col col-lg col-text">
              <p>
                Adaptador bridado sin fondo
              </p>
            </div>
            <div class="col col-lg col-btns">
              <div class="d-box">
                <div class="_btn">+</div>
                <div class="num">1</div>
                <div class="_btn">-</div>

                <a class="btn-add btn-red">QUITAR</a>
              </div>
            </div>
          </div>
        </div>
        <!--  -->
      </div>

      <div class="d-block position-relative mt-4">
        <hr class="mt-1" />
        <p class="soft-note">
          Información que el cliente ha ingresado para las especificaciones de cada uno de los productos para crear una cotización más precisa. Y que ayude al equiipo a comprender claramente lo que el cliente necesita para dar un mejor servicio.
        </p>
      </div>

      <p class="text-center text-md-right mt-4">
        <a class="btn btn-secondary b-alter" @click="goBack">ANTERIOR</a>
        <b-button type="submit" class="b-alter b-submit">ENVIAR</b-button>
      </p>
    </div>

    <!-- Paso 5 -->
    <div class="box-quotation" v-if="currentStep == 5">
      <h5>¡Gracias! Su cotización ha sido enviada</h5>
      <hr class="c-hr" />

      <p class="py-5 text-center">
        <img class="img-fluid" src="public/images/shared/logo.png">
      </p>
    </div>



    <!-- Modal del paso 2 -->
    <b-modal id="modal-quotation" ref="modal-quo" centered hide-footer no-close-on-backdrop no-close-on-esc size="lg" title="Agregar productos">
      <h6 class="mb-4 soft-title">Buscar: <strong>{{ keywords }}</strong></h6>

      <div class="box-quotation_added-products">
        <div class="b-product" v-for="(s, iReIdx) in 3">
          <div class="col-md-3 col-img">
            <img src="public/images/pages/products/product-1.jpg">
          </div>
          <div class="col col-md-9 col-lg col-text">
            <p>
              Adaptador bridado sin fondo
            </p>
          </div>
          <div class="col col-lg col-btns">
            <div class="d-box">
              <div class="_btn">+</div>
              <div class="num">1</div>
              <div class="_btn">-</div>

              <a class="btn-add btn-blue">AGREGAR</a>
            </div>
          </div>
        </div>
      </div>
    </b-modal>

  </b-form>
</template>

<script>
export default {
  data(){
    return{
      currentStep: 1,
      next: true,
      keywords: null,

      form: {
        nombre: null,
        email: null,
        tel: null
      }
    }
  },

  methods: {
    searchProds(){
      this.$refs['modal-quo'].show();
    },

    goBack(){
      window.scrollTo(0,200);
      this.currentStep--;
    },

    onSubmit(evt){
      evt.preventDefault();

      window.scrollTo(0,200);
      console.log('antes');
      this.next = true;

      if(this.currentStep == 1){
        this.currentStep = 2;
        this.next = false;
        console.log('paso 1 a 2');
      }

      if(this.currentStep == 2 && this.next == true){
        this.currentStep = 3;
        this.next = false;
        console.log('paso 2 a 3');
      }

      if(this.currentStep == 3 && this.next == true){
        this.currentStep = 4;
        this.next = false;
        console.log('paso 3 a 4');
      }

      if(this.currentStep == 4 && this.next == true){
        this.currentStep = 5;
        this.next = false;
        console.log('paso 4 a 5');
      }
    }
  }
}
</script>
