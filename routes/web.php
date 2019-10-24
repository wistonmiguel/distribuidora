<?php
Auth::routes();

Route::get('/', 'HomeController@index')->name('index');
Route::get('/home', 'HomeController@home')->name('home');
Route::get('/almacenes/getAll', 'AlmacenController@getAll')->name('allAlmacen');
Route::resource('/almacenes', 'AlmacenController')->middleware('auth');
Route::get('/proveedores/getAll', 'ProveedorController@getAll')->name('allProducto');
Route::resource('/proveedores', 'ProveedorController')->middleware('auth');
Route::resource('/productos', 'ProductoController')->middleware('auth');
