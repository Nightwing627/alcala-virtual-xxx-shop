import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

//Componentes
//import Login from './components/admin/Login.vue';

const page="./components/page/";

const MyRouter = new VueRouter({
  	routes:[
	    { path: '/', component: require(page+'home.vue') },

		{ path: '/productos', component: require(page+'products/results.vue'), meta:{title:"Productos"}},
		{ path: '/producto/:id?', component: require(page+'products/description.vue'), meta:{title:"Producto"}},
		{ path: '/subcategoria/:id?', component: require(page+'products/category.vue'), meta:{title:"Producto"}},
		{ path: '/busqueda', component: require(page+'products/results.vue'), meta:{title:"Busqueda"}},

		{ path: '/categoria/:id?', component: require(page+'category/index.vue'), meta:{title:"Categoria"}},

    { path: '/pagos-y-envios', component: require(page+'payments-shipments/index.vue'), meta:{title:"Pagos y envíos"}},
    { path: '/garantias-confidencialidad', component: require(page+'guarantee/index.vue'), meta:{title:"Garantías y conficencialidad"}},
    { path: '/nosotros', component: require(page+'about-us/index.vue'), meta:{title:"Nosotros"}},
    { path: '/preguntas-frecuentes', component: require(page+'faqs/index.vue'), meta:{title:"Preguntas frecuentes"}},
		{ path: '/tiendas', component: require(page+'stores/index.vue'), meta:{title:"Tiendas"}},
    { path: '/contacto', name: 'contactPage', component: require(page+'contact/index.vue'), meta:{title:"Contacto"}},

    	{ path: '/blog', component: require(page+'blog/index.vue'), meta:{title:"Blog"}},
    	{ path: '/blog/:id', component: require(page+'blog/detail.vue'), meta:{title:"Blog"}},

		{ path: '/aviso-de-privacidad', component: require(page+'text-page/aviso.vue'), meta:{title:"Aviso de Privacidad"}},
		{ path: '/terminos-y-condiciones', component: require(page+'text-page/terminos.vue'), meta:{title:"Términos y condiciones"}},

		{ path: '/cart/:step?', component: require(page+'carrito/index.vue'), meta:{title:"Mi carrito de compras"}},
		{ path: '/mis-favoritos', component: require(page+'carrito/mis-favoritos.vue'), meta:{title:"Mis favoritos"}},
		{ path: '/historial-de-compras', component: require(page+'carrito/historial.vue'), meta:{title:"Mi historial de compras"}},

		{ path: '/login', component: require(page+'user-access/login.vue'), meta:{title:"Iniciar sesión"}},
		{ path: '/recuperar-contrasena', component: require(page+'user-access/reset-password.vue'), meta:{title:"Recuperar contraseña"}},
		{ path: '/registrarse', component: require(page+'user-access/register.vue'), meta:{title:"Registrarse"}},

		{ path: '/usuario', component: require(page+'usuario-cuenta/index.vue'), meta:{ title: 'Mi datos' },
			children: [
			{
				path: '/',
				component: require(page+'usuario-cuenta/mis-datos.vue'),
				meta:{ title: 'Mis datos' }
			},
			{
				path: 'contrasena',
				component: require(page+'usuario-cuenta/contrasena.vue'),
				meta:{ title: 'Cambiar contraseña' }
			},

			// {
			//   path: 'nueva-cotizacion',
			//   component: require(page+'usuario-cuenta/nueva-cotizacion.vue'),
			//   meta:{ title: 'Mis cotizaciones' }
			// },
			// {
			//   path: 'mis-cotizaciones',
			//   component: require(page+'usuario-cuenta/mis-cotizaciones.vue'),
			//   meta:{ title: 'Mis facturas' }
			// }
	  	]}
	  ]
});

MyRouter.beforeEach((to, from, next) => {
	window.scrollTo(0,0);
	if(window.app.__vue__ && window.app.__vue__.$refs.loadingBar){
		window.app.__vue__.$refs.loadingBar.start();
	}
	next();
});

MyRouter.afterEach((to, from) => {

	if(window.app.__vue__ && window.app.__vue__.$refs.loadingBar){
		setTimeout(()=>{
			window.app.__vue__.$refs.loadingBar.done();
		},500);
	}


});

//Titulos del website
import VueDocumentTitlePlugin from "vue-document-title-plugin";
Vue.use(VueDocumentTitlePlugin, MyRouter,
	{ defTitle: "Virtual Sex Shop Gdl Alcala", filter: (title)=>{ return title+" - Virtual Sex Shop Gdl Alcala"; } }
);

// export {routes};
export default MyRouter;
