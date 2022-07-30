import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

const page="./components/admin/";

const MyRouter = new VueRouter({
  	routes:[
	    { path: '/', redirect:"/login"},
	    { path: '/login', component: require(page+'login.vue'), meta:{title:"Login"}},
	    { path: '/home', component: require(page+'home.vue'), meta:{title:"Home"}},
	    { path: '/profile', component: require(page+'me.vue'), meta:{title:"Mi perfil"}},
	    //Usuarios
	    { path: '/users', component: require(page+'users/index.vue'), meta:{title:"Usuarios"}},
	    { path: '/users/edit', component: require(page+'users/edit.vue'), meta:{title:"Editar"}},//Cuando no envian parametro
	    { path: '/users/edit/:id', component: require(page+'users/edit.vue'), meta:{title:"Editar"}},//Con parametro
	    //Roles
	    { path: '/roles', component: require(page+'configuration/roles.vue'), meta:{title:"Roles"}},
	    { path: '/roles/edit/:id', component: require(page+'configuration/permissions.vue'), meta:{title:"Editar"}},
	    //Banners
	    { path: '/banners', component: require(page+'banners/index.vue'), meta:{title:"Bnners"}},
	    { path: '/banners/edit', component: require(page+'banners/edit.vue'), meta:{title:"Editar"}},//Cuando no envian parametro
	    { path: '/banners/edit/:id', component: require(page+'banners/edit.vue'), meta:{title:"Editar"}},//Con parametro
	    //Terminos y condiciones
		{ path: '/terminos', component: require(page+'extras/terminos.vue'), meta:{title:"Terminos y condiciones"}},//Con parametro
		{ path: '/privacidad', component: require(page+'extras/privacidad.vue'), meta:{title:"Aviso de Privacidad"}},//Con parametro
	    //Redes Sociales
	    { path: '/redes', component: require(page+'extras/redes.vue'), meta:{title:"Redes Sociales"}},//Con parametro
	    //Historia y Nosotros
		{ path: '/historia', component: require(page+'extras/nosotros.vue'), meta:{title:"Historia"}},//Con parametro
		{ path: '/envio', component: require(page+'extras/envio.vue'), meta:{title:"Envio"}},//Con parametro
		{ path: '/titulos', component: require(page+'extras/titles.vue'), meta:{title:"Titulos"}},//Con parametro
		{ path: '/faqs', component: require(page+'extras/faq.vue'), meta:{title:"Preguntas frecuentes"}},//Con parametro
		{ path: '/pagos', component: require(page+'extras/pagos.vue'), meta:{title:"Pagos y Envios"}},//Con parametro
		{ path: '/garantia', component: require(page+'extras/garantia.vue'), meta:{title:"Garantia y confidencialidad"}},//Con parametro

		//Clientes
	    { path: '/customers', component: require(page+'customers/index.vue'), meta:{title:"Clientes"}},
	    { path: '/customers/edit', component: require(page+'customers/edit.vue'), meta:{title:"Editar"}},//Cuando no envian parametro
		{ path: '/customers/edit/:id', component: require(page+'customers/edit.vue'), meta:{title:"Editar"}},//Con parametro

		//Pedidos
        { path: '/orders', component: require(page+'orders/index.vue'), meta:{title:"Pedidos"}},
		{ path: '/orders/detail/:id', component: require(page+'orders/edit.vue'), meta:{title:"Ver Detalle"}},
		
		//Productos
	    { path: '/products', component: require(page+'products/index.vue'), meta:{title:"Productos"}},
	    { path: '/products/edit', component: require(page+'products/edit.vue'), meta:{title:"Editar"}},//Cuando no envian parametro
		{ path: '/products/edit/:id', component: require(page+'products/edit.vue'), meta:{title:"Editar"}},//Con parametro
		{ path: '/products/import', component: require(page+'products/import.vue'), meta:{title:"Importar"}},

		//categorias
	    { path: '/categorias', component: require(page+'categories/index.vue'), meta:{title:"Categorias"}},
	    { path: '/categorias/edit', component: require(page+'categories/edit.vue'), meta:{title:"Editar"}},//Cuando no envian parametro
		{ path: '/categorias/edit/:id', component: require(page+'categories/edit.vue'), meta:{title:"Editar"}},//Con parametro

		//subcategorias
	    { path: '/subcategorias', component: require(page+'subcategories/index.vue'), meta:{title:"Subcategorias"}},
	    { path: '/subcategorias/edit', component: require(page+'subcategories/edit.vue'), meta:{title:"Editar"}},//Cuando no envian parametro
		{ path: '/subcategorias/edit/:id', component: require(page+'subcategories/edit.vue'), meta:{title:"Editar"}},//Con parametro

		//noticias
		{ path: '/news', component: require(page+'news/index.vue'), meta:{title:"Noticias" }},
		{ path: '/news/edit', component: require(page+'news/edit.vue'), meta:{title:"Editar" }},
		{ path: '/news/edit/:id', component: require(page+'news/edit.vue'), meta:{title:"Editar"}},

		{ path: '/contacts', component: require(page+'contact/index.vue'), meta:{title:"Contactos" }},
		{ path: '/newsletters', component: require(page+'newsletter/index.vue'), meta:{title:"newsletters" }},

		//Cupones
		{ path: '/coupons', component: require(page+'coupons/index.vue'), meta:{title:"Cupones"}},
		{ path: '/coupon/edit', component: require(page+'coupons/edit.vue'), meta:{title:"Editar"}},
		{ path: '/coupon/edit/:id', component: require(page+'coupons/edit.vue'), meta:{title:"Editar"}},

		//tiendas
	    { path: '/stores', component: require(page+'stores/index.vue'), meta:{title:"Tiendas"}},
	    { path: '/stores/edit', component: require(page+'stores/edit.vue'), meta:{title:"Editar"}},//Cuando no envian parametro
		{ path: '/stores/edit/:id', component: require(page+'stores/edit.vue'), meta:{title:"Editar"}},//Con parametro

	  ]
});

//Titulos del website
import VueDocumentTitlePlugin from "vue-document-title-plugin";
Vue.use(VueDocumentTitlePlugin, MyRouter, 
	{ defTitle: "SexShop", filter: (title)=>{ return title+" - SexShop"; } }
);
	  
// export {routes};
export default MyRouter;