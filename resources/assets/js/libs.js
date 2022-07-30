/*
 *
 * Estas librerias estan presentes tanto en la website como en el dashboard
 *
 */

//Librerias necesarias
import VeeValidate, { Validator } from 'vee-validate';
import es from 'vee-validate/dist/locale/es';
import Datetime from 'vue-datetime';
import vSelect from 'vue-select';
import cart from './services/cart.js';
import vueTopprogress from 'vue-top-progress';
// import * as VueGoogleMaps from 'vue2-google-maps';
/*import svgicon from "vue-svgicon";
import svgs from "./svgs/index.js";*/
import vue2Dropzone from 'vue2-dropzone';
import 'vue2-dropzone/dist/vue2Dropzone.min.css';
import SweetModal from 'sweet-modal-vue/src/plugin.js';
import VueNumberInput from '@chenfengyuan/vue-number-input';

//Funcion para añadirlas a Vue
function fire(Vue){
	//Vee-validate	
	Validator.localize('es', es);
	Vue.use(VeeValidate,{locale:"es"});

	//vue-datetime	
	Vue.use(Datetime);

	// Vue2-Dropzone
	Vue.component('vue-dropzone', vue2Dropzone);

	//Vue-select	
	Vue.component('v-select', vSelect);
	Vue.use(SweetModal);

	//
	Vue.use(VueNumberInput);

    /*/Vue-svgicon
     Vue.use(svgicon, {
		  tagName: 'svgicon',
			classPrefix: 'vue-svg'
	});

    //iconos svg
    Vue.use(svgs);*/

	//Google map
	// Vue.use(VueGoogleMaps, {
	// 	load: {
	// 		key: 'AIzaSyAtuB4iDyT81TK-Mg5DfvRhoKmkGORys_A'
	// 		//libraries: 'places', // This is required if you use the Autocomplete plugin
	// 				// OR: libraries: 'places,drawing'
	// 				// OR: libraries: 'places,drawing,visualization'
	// 				// (as you require)
	// 	}
	// });

	//Loading bar
	Vue.use(vueTopprogress);

	// Vue.use(cart,{token_sandbox:"AZ2Ddsdu1l0uRI8tFkpvbapGVsdcA2T2eKzLBEMZpbHH5i50jVkK-cIgMHe-dCP7MGsgZjWRleR5qgh8"});

}



// Install by default if using the script tag
if (typeof window !== 'undefined' && window.Vue) {
  window.Vue.use(plugin)
}

export default fire;