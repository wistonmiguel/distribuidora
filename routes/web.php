<?php
Auth::routes();

Route::get('/', 'HomeController@index')->name('index');
Route::get('/home', 'HomeController@home')->name('home');
Route::resource('/almacenes', 'AlmacenController')->middleware('auth');
Route::resource('/proveedores', 'ProveedorController')->middleware('auth');
Route::resource('/productos', 'ProductoController')->middleware('auth');
