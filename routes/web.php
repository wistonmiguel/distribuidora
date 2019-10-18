<?php
Auth::routes();

Route::get('/', 'HomeController@index')->name('index');
Route::get('/home', 'HomeController@home')->name('home');
Route::resource('/almacen', 'AlmacenController')->middleware('auth');