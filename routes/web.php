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
Route::get('/inventarios/getAll', 'InventarioController@getAll')->name('allInventario');
Route::resource('/inventarios', 'InventarioController')->middleware('auth');
Route::get('/compradores/getAll', 'CompradorController@getAll')->name('allComprador');
Route::resource('/compradores', 'CompradorController')->middleware('auth');
Route::get('/vendedores/getAll', 'VendedorController@getAll')->name('allVendedor');
Route::resource('/vendedores', 'VendedorController')->middleware('auth');
Route::get('/clientes/getAll', 'ClienteController@getAll')->name('allCliente');
Route::resource('/clientes', 'ClienteController')->middleware('auth');
Route::get('/tipoPagos/getAll', 'TipoPagoController@getAll')->name('allTipoPago');
Route::resource('/tipoPagos', 'TipoPagoController')->middleware('auth');
Route::get('/compras/getAll', 'CompraController@getAll')->name('allCompra');
Route::post('/compras/devAll', 'CompraController@devAll')->name('devolucionCompra');
Route::resource('/compras', 'CompraController')->middleware('auth');
Route::get('/detallecompras/getAll', 'CompraDetalleController@getAll')->name('allCompraDetalle');
Route::resource('/detallecompras', 'CompraDetalleController')->middleware('auth');
Route::get('/comprasdevolucion/getAll', 'CompraDevolucionController@getAll')->name('allCompraDevolucion');
Route::resource('/comprasdevolucion', 'CompraDevolucionController')->middleware('auth');
Route::get('/detallecomprasdevolucion/getAll', 'CompraDetalleDevolucionController@getAll')->name('allCompraDetalleDevolucion');
Route::resource('/detallecomprasdevolucion', 'CompraDetalleDevolucionController')->middleware('auth');
Route::get('/pedidos/getAll', 'PedidoController@getAll')->name('allPedido');
Route::resource('/pedidos', 'PedidoController')->middleware('auth');
Route::get('/detallepedidos/getAll', 'PedidoDetalleController@getAll')->name('allCompraDetalle');

Route::get('/ventas/getAll', 'VentaController@getAll')->name('allVenta');
Route::post('/ventas/devAll', 'VentaController@devAll')->name('devolucionVenta');
Route::resource('/ventas', 'VentaController')->middleware('auth');
