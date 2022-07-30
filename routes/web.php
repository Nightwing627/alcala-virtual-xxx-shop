<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/','HomeController@home');
Route::get('/admin','HomeController@admin');
Route::get('/img/{key}','MediaController@getImage');
Route::get('/docs/{key}','MediaController@getDocument');

//nosotros page
Route::get('/historia', "ExtrasController@getNosotros");

//noticias
Route::get('/noticias', "NoticiaController@getNews");
Route::get('/noticia/{id}', "NoticiaController@show");

//Home
Route::get('/home', "HomeController@getHome");

//productos
Route::get('/productos', "ProductController@getProducts");
Route::get('/productos/category/{id}', "ProductController@getProductsCategory");
Route::post('/productos/category/{id}', "ProductController@getProductsCategoryFilters");
Route::get('/producto/{id}', "ProductController@frontShow");
Route::get('/relacionados/{category_id}', "ProductController@relacionados");
Route::get('/productos/subcategory/{id}', "ProductController@getProductsSubcategory");
Route::post('/productos/subcategory/{id}', "ProductController@getProductsSubcategoryFilters");

//search
Route::post('/productos/search', "ProductController@search");

//usuario
Route::post('/front/usuario/nuevo',"UsersController@nuevo");
Route::post('/front/usuario/cambiarContra',"UsersController@changePass")->middleware(["jwt.auth"]);
Route::post('/front/usuario/guardarCambios',"UsersController@guardarCambios")->middleware(["jwt.auth"]);
Route::post('/front/recuperarContra', "UsersController@recuperarContra");

//carrito
Route::post('/carrito/obtenerProductos',"CartController@obtenerProductos");
Route::post('/front/guardar-pedido', "CartController@OrderStore");
Route::post('/carrito/historial',"OrderController@historialCompras");
Route::post('/front/buscarCupon',"CouponsController@buscarCupon");

//marcas
Route::get('/getMarcas', "MarcaController@index");
//categorias
Route::get('/getCategories', "CategoryController@index");
//subcategorias
Route::get('/getSubcategories', "SubcategoryController@index");
Route::get('/getSubcategoriesByCategory/{id}', "SubcategoryController@getSubcategories");


//exportar
// Route::get('/products/export',"ProductsController@export");

//ciudades y estados
Route::get('/estados',"StateController@index");
Route::get('/ciudades/{state_id}',"TownController@index");

//Redes
Route::get('/redes', "ExtrasController@getRedes");
//Terminos y condiciones
Route::get('/terminos', "ExtrasController@getTerminos");
//Aviso de Privacidad
Route::get('/privacidad', "ExtrasController@getPrivacidad");
Route::get('/historia', "ExtrasController@getNosotros");
Route::get('/garantia', "ExtrasController@getGarantia");
Route::get('/pagos', "ExtrasController@getPagos");
Route::get('/faqs', "ExtrasController@getFaq");
Route::get('/stores', "StoreController@index");

//contacto
Route::post('/contacto',"ContactController@store");
//newsletter
Route::post('/newsletter',"NewsletterController@store");
Route::get('/newsletter/export',"NewsletterController@export");
//exportar
Route::get('/newsletter/export',"NewsletterController@export");
Route::get('/orders/export',"OrderController@export");
Route::get('/ordersDetails/export/{id}',"OrderController@exportDetails");
Route::get('/getComplementarios/{id}', "ComplementarioController@frontComplementarios");
Route::get('/getRelacionados/{id}', "RelacionadoController@frontRelacionados");

//zipcode
Route::get('/getZipCode/{postalCode}',"SepomexController@getZipCode");
Route::get('/infoZipCode/{postalCode}',"SepomexController@infoZipCode");