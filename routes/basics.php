<?php

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Estas rutas no requieren autentificacion
Route::post('/login/',"AuthenticateController@authenticate");
Route::post('/logout/',"AuthenticateController@logout");


//Grupo de rutas que requieren autentificacion
Route::middleware(["jwt.auth"])->group(function(){
	//Estas rutas no requieren ninguna validacion
	Route::get('/me/',"AuthenticateController@me");			//Obtener informacion de la session
	Route::post('/me/',"AuthenticateController@update");	//Actualizacion de informacion de usuario
	Route::get('/menu/',"MenusController@index");			//Obtener menu de usuario

	//Usuarios
	Route::get('/users/',"UsersController@index")->middleware('auth.perm:view_users');
	Route::get('/user/{id}',"UsersController@show")->middleware('auth.perm:view_users');
	Route::post('/user/',"UsersController@store")->middleware('auth.perm:edit_users');
	Route::post('/user/{id}',"UsersController@update")->middleware('auth.perm:edit_users');
	Route::delete('/user/{id}',"UsersController@destroy")->middleware('auth.perm:edit_users');
	Route::delete('/users/',"UsersController@destroyMultiple")->middleware('auth.perm:edit_users');

	//Edicion de roles
	Route::get('/permissions/','RolesController@permissions')->middleware('auth.role:administrador');
	Route::get('/roles/','RolesController@index')->middleware('auth.role:administrador');
	Route::get('/role/{id}','RolesController@show')->middleware('auth.role:administrador');
	Route::post('/role/','RolesController@store')->middleware('auth.role:administrador');
	Route::post('/role/{id}','RolesController@update')->middleware('auth.role:administrador');
	Route::delete('/role/{id}','RolesController@destroy')->middleware('auth.role:administrador');

	//Notificaciones
	Route::get('/notifications/{user_id}','NotificationController@index');
	Route::get('/notifications/{user_id}/resume','NotificationController@resume');
	Route::post('/notifications/{user_id}/read_all','NotificationController@readAll');
	Route::post('/notifications/create','NotificationController@store');

});