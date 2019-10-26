<?php
Auth::routes();

Route::get('/', 'HomeController@index')->name('index');
Route::get('/home', 'HomeController@home')->name('home');
Route::get('/almacenes/getAll', 'AlmacenController@getAll')->name('allAlmacen');
Route::resource('/almacenes', 'AlmacenController')->middleware('auth');
Route::get('/proveedores/getAll', 'ProveedorController@getAll')->name('allProveedor');
Route::resource('/proveedores', 'ProveedorController')->middleware('auth');
Route::get('/productos/getAll', 'ProductoController@getAll')->name('allProducto');
Route::resource('/productos', 'ProductoController')->middleware('auth');
Route::resource('/inventarios', 'InventarioController')->middleware('auth');
