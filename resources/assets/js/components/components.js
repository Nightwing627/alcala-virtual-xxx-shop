/*
 *
 * Estos componentes estan presentes solo en el website
 *
 */

const page="./page/";
// import slick from 'vue-slick';
import BootstrapVue from 'bootstrap-vue';
import VueAwesomeSwiper from 'vue-awesome-swiper';
import VueSweetalert2 from 'vue-sweetalert2';
import VueSocialSharing from 'vue-social-sharing';

function plugin (Vue) {
	//Componentes llamados
  Vue.component('my-header', require(page+'shared/header.vue'));
	Vue.component('my-footer', require(page+'shared/footer.vue'));
	// Vue.component('slick',slick);
  Vue.use(BootstrapVue);
  Vue.use(VueAwesomeSwiper, /* { default global options } */);
  Vue.use(VueSweetalert2);
  Vue.use(VueSocialSharing);
}

// Install by default if using the script tag
if (typeof window !== 'undefined' && window.Vue) {
  window.Vue.use(plugin)
}

export default plugin
