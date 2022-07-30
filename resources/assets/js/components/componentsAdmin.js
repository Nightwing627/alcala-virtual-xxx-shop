/*
 *
 * Estos componentes estan presentes solo en el dashboard
 *
 */

const page="./admin/";

function plugin (Vue) {
	//Componentes llamados
  	Vue.component('loading-spinner', require(page+'shared/spinner.vue'));
	Vue.component('admin-header', require(page+'shared/header.vue'));
	Vue.component('admin-menu', require(page+'shared/menu.vue'));
	Vue.component('admin-footer', require(page+'shared/footer.vue'));
	Vue.component('vSwitch', require(page+'shared/Switch.vue'));
	Vue.component('messages', require(page+'shared/messages.vue'));
	Vue.component('input-form', require(page+'shared/input.vue'));
	Vue.component('select-form', require(page+'shared/select.vue'));
	Vue.component('checkbox-form', require(page+'shared/checkbox.vue'));
	Vue.component('switch-form', require(page+'shared/checkbox-switch.vue'));
	Vue.component('file-form', require(page+'shared/file.vue'));
	Vue.component('text-form', require(page+'shared/text.vue'));
	Vue.component('login', require(page+'login.vue'));
}

// Install by default if using the script tag
if (typeof window !== 'undefined' && window.Vue) {
  window.Vue.use(plugin)
}

export default plugin