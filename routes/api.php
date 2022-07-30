<?php

use Illuminate\Http\Request;

require('basics.php');

//Route::post('/contact','MailsController@contact');
Route::get('/products/export',"ProductController@export");

Route::post('/paypal/payment' ,"PaypalController@payment");
Route::post('/paypal/onAuthorize',"PaypalController@onAuthorize");

//Grupo de rutas que requieren autentificacion
Route::middleware(["jwt.auth"])->group(function(){
	//Banners
	Route::get('/banners/',"BannersController@index")->middleware('auth.perm:banners');
	Route::get('/banners/{id}',"BannersController@show")->middleware('auth.perm:banners');
	Route::post('/banners/',"BannersController@store")->middleware('auth.perm:banners');
	Route::post('/banners/{id}',"BannersController@update")->middleware('auth.perm:banners');
	Route::delete('/banners/{id}',"BannersController@destroy")->middleware('auth.perm:banners');
	Route::delete('/banners/',"BannersController@destroyMultiple")->middleware('auth.perm:banners');

	//Terminos y condiciones
	Route::get('/terminos', "ExtrasController@getTerminos")->middleware('auth.perm:extras');
	Route::post('/terminos', "ExtrasController@updateTerminos")->middleware('auth.perm:extras');
	//Aviso de Privacidad
	Route::get('/privacidad', "ExtrasController@getPrivacidad")->middleware('auth.perm:extras');
	Route::post('/privacidad', "ExtrasController@updatePrivacidad")->middleware('auth.perm:extras');
	//Redes
	Route::get('/redes', "ExtrasController@getRedes")->middleware('auth.perm:extras');
	Route::post('/redes', "ExtrasController@updateRedes")->middleware('auth.perm:extras');
	//envios
	Route::get('/envio', "ExtrasController@getEnvio")->middleware('auth.perm:extras');
	Route::post('/envio', "ExtrasController@updateEnvio")->middleware('auth.perm:extras');
	//FAQ
	Route::get('/faqs', "ExtrasController@getFaq")->middleware('auth.perm:extras');
	Route::post('/faqs', "ExtrasController@updateFaq")->middleware('auth.perm:extras');
	Route::get('/pagos', "ExtrasController@getPagos")->middleware('auth.perm:extras');
	Route::post('/pagos', "ExtrasController@updatePagos")->middleware('auth.perm:extras');
	Route::get('/garantia', "ExtrasController@getGarantia")->middleware('auth.perm:extras');
	Route::post('/garantia', "ExtrasController@updateGarantia")->middleware('auth.perm:extras');
	//Nosotros
	Route::get('/historia', "ExtrasController@getNosotros")->middleware('auth.perm:extras');
	Route::post('/historia', "ExtrasController@updateNosotros")->middleware('auth.perm:extras');

	//Clientes
	Route::get('/customers',"CustomerController@index")->middleware('auth.perm:customers');
	Route::get('customers/{id}',"CustomerController@show")->middleware('auth.perm:customers');
	Route::post('customers/',"CustomerController@store")->middleware('auth.perm:customers');
	Route::post('customers/{id}',"CustomerController@update")->middleware('auth.perm:customers');
	Route::delete('customers/{id}',"CustomerController@destroy")->middleware('auth.perm:customers');
	Route::delete('/customers',"CustomerController@destroyMultiple")->middleware('auth.perm:customers');

	//pedidos
	Route::get('/orders',"OrderController@index")->middleware('auth.perm:orders');
	Route::get('orders/{id}',"OrderController@show")->middleware('auth.perm:orders');
	Route::post('/orders/cancel','OrderController@cancel')->middleware('auth.perm:orders');
	Route::post('/orders/pay','OrderController@pay')->middleware('auth.perm:orders');
	Route::post('/order/{id}',"OrderController@setStatus")->middleware('auth.perm:orders');

	//productos
	Route::get('/products',"ProductController@index")->middleware('auth.perm:products');
	Route::get('/products/{id}',"ProductController@show")->middleware('auth.perm:products');
	Route::post('/products',"ProductController@store")->middleware('auth.perm:products');
	Route::post('/products/{id}',"ProductController@update")->middleware('auth.perm:products');
	Route::delete('/products/{id}',"ProductController@destroy")->middleware('auth.perm:products_delete');
	Route::delete('/products',"ProductController@destroyMultiple")->middleware('auth.perm:products_delete');
	//importar
	Route::post('/importProducts',"ProductController@import")->middleware('auth.perm:products');

	//categorias
	Route::get('/categories',"CategoryController@index");
	Route::get('/categories/{id}',"CategoryController@show")->middleware('auth.perm:categories');
	Route::post('/categories',"CategoryController@store")->middleware('auth.perm:categories');
	Route::post('/categories/{id}',"CategoryController@update")->middleware('auth.perm:categories');
	Route::delete('/categories/{id}',"CategoryController@destroy")->middleware('auth.perm:categories');
	Route::delete('/categories',"CategoryController@destroyMultiple")->middleware('auth.perm:categories');

	//subcategorias
	Route::get('/subcategories',"SubcategoryController@index");
	Route::get('/subcategories/{id}',"SubcategoryController@show")->middleware('auth.perm:categories');
	Route::post('/subcategories',"SubcategoryController@store")->middleware('auth.perm:categories');
	Route::post('/subcategories/{id}',"SubcategoryController@update")->middleware('auth.perm:categories');
	Route::delete('/subcategories/{id}',"SubcategoryController@destroy")->middleware('auth.perm:categories');
	Route::delete('/subcategories',"SubcategoryController@destroyMultiple")->middleware('auth.perm:categories');
	Route::get('/getSubcategories/{id}',"SubcategoryController@getSubcategories");

	//Noticias
	Route::get('/news','NoticiaController@index')->middleware('auth.perm:news');
	Route::get('/news/{id}','NoticiaController@show')->middleware('auth.perm:news');
	Route::post('/news',"NoticiaController@store")->middleware('auth.perm:news');
	Route::post('/news/{id}',"NoticiaController@update")->middleware('auth.perm:news');
	Route::delete('/news/{id}',"NoticiaController@destroy")->middleware('auth.perm:news');
	Route::delete('/news',"NoticiaController@destroyMultiple")->middleware('auth.perm:news');

	//Galeria de los productos
	Route::get('/productImage/{id}', "ProductController@getImages")->middleware('auth.perm:products');
	Route::post('/productImage/{id}', "ProductController@uploadImage")->middleware('auth.perm:products');
	Route::delete('/productImage/{id}', "ProductController@deleteImage")->middleware('auth.perm:products');

	//contacto
	Route::get('/contact',"ContactController@index");
	//newsletter
	Route::get('/newsletter',"NewsletterController@index");

	//Rutas de Cupones
	Route::get('/coupons',"CouponsController@index");
	Route::get('/coupons/{id}',"CouponsController@show");
	Route::post('/coupons',"CouponsController@store");
	Route::post('/coupons/{id}',"CouponsController@update");
	Route::delete('/coupons/{id}',"CouponsController@destroy");
	Route::delete('/coupons',"CouponsController@destroyMultiple");

	//stores
	Route::get('/stores',"StoreController@index")->middleware('auth.perm:stores');
	Route::get('/stores/{id}',"StoreController@show")->middleware('auth.perm:stores');
	Route::post('/stores',"StoreController@store")->middleware('auth.perm:stores');
	Route::post('/stores/{id}',"StoreController@update")->middleware('auth.perm:stores');
	Route::delete('/stores/{id}',"StoreController@destroy")->middleware('auth.perm:stores');
	Route::delete('/stores',"StoreController@destroyMultiple")->middleware('auth.perm:stores');
});
