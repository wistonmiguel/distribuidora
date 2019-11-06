<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB; use App\Quotation;
use App\Venta;
use App\VentaDetalle;
use App\VentaDevolucion;
use App\VentaDetalleDevolucion;
use App\Inventario;
use PDF;

class VentaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){

          $data_model = Venta::select(DB::raw("DATE_FORMAT(venta.Fecha, '%d/%m/%Y') AS FechaESP"), "venta.*", "cliente.Nombre AS NCli", "vendedor.Nombre AS NVend", "tipo_pago.Nombre AS NTP")
          ->join("cliente","cliente.idCliente","=","venta.idCliente")
          ->join("vendedor","vendedor.idVendedor","=","venta.idVendedor")
          ->join("tipo_pago","tipo_pago.idTipoPago","=","venta.idTipoPago")
          ->orderBy('venta.idTransaccion', 'DESC')->paginate(10);

          return [
            'pagination' => [
                'total'         => $data_model->total(),
                'current_page'  => $data_model->currentPage(),
                'per_page'      => $data_model->perPage(),
                'last_page'     => $data_model->lastPage(),
                'from'          => $data_model->firstItem(),
                'to'            => $data_model->lastItem(),
            ],
            'model' => $data_model
        ];
    }
    else
    {
        return view('venta');
    }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*
        $request->validate([
            'Fecha' => 'required',
            'Estado' => 'required',
            'idTipoPago' => 'required',
            'idVendedor' => 'required',
            'idProveedor' => 'required'
        ]);
        */

    DB::beginTransaction();

    try{
        // Database operations
        $data_model = new Venta();
        $data_model->Fecha = $request->newModel['Fecha'];
        $data_model->Estado = $request->newModel['Estado'];
        $data_model->Factura = $request->newModel['Factura'];
        $data_model->idTipoPago = $request->newModel['idTipoPago'];
        $data_model->idVendedor = $request->newModel['idVendedor'];
        $data_model->idCliente = $request->newModel['idCliente'];

        if($data_model->save())
            {
                $last_id = $data_model->idTransaccion;

                //GUARDAR DETALLE
                foreach ($request->newModel2 as $detalle) {
                    //echo $detalle['idProducto']." con idTransaccion: ".$last_id." <br>";
                    $data_model2 = null;
                    $data_model2 = new VentaDetalle();
                    $data_model2->idProducto = $detalle['idProducto'];
                    $data_model2->idTransaccion = $last_id;
                    $data_model2->Cantidad = $detalle['Cantidad'];
                    $data_model2->Precio = $detalle['Precio'];
                    $data_model2->save();

                    //ACTUALIZAR INVENTARIO
                    $model_finded = Inventario::select("inventario.idInventario", "inventario.Stock")->where("inventario.idProducto", "=", $detalle['idProducto'])->get();
                    $stockActual = $model_finded[0]->Stock;
                    $idInventario = $model_finded[0]->idInventario;

                    if($model_finded){
                        $data_model3 = Inventario::find($idInventario);
                        $data_model3->Stock = $stockActual - $detalle['Cantidad'];
                        $data_model3->save();
                    }
                }
            }

        DB::commit();
        //return $data_model;
    }catch(\Exception $e){
    // rollback operation for failure
        DB::rollback();
    }
    }

    public function devAll(Request $request)
    {
    DB::beginTransaction();

    try{
        // Database operations
        $data_model = new VentaDevolucion();
        $data_model->Fecha = $request->newModel['Fecha'];
        $data_model->Estado = $request->newModel['Estado'];
        $data_model->Factura = $request->newModel['Factura'];
        $data_model->idCliente = $request->newModel['idCliente'];
        $data_model->idVendedor = $request->newModel['idVendedor'];

        if($data_model->save())
            {
                echo $request;
                $last_id = $data_model->idTransaccion;

                //GUARDAR DETALLE
                foreach ($request->newModel2 as $detalle) {
                    $data_model2 = null;
                    $data_model2 = new VentaDetalleDevolucion();
                    $data_model2->idProducto = $detalle['idProducto'];
                    $data_model2->idTransaccion = $last_id;
                    $data_model2->Cantidad = $detalle['Cantidad'];
                    $data_model2->Precio = $detalle['Precio'];
                    $data_model2->save();

                    //ACTUALIZAR INVENTARIO
                    $model_finded = Inventario::select("inventario.idInventario", "inventario.Stock")->where("inventario.idProducto", "=", $detalle['idProducto'])->get();
                    $stockActual = $model_finded[0]->Stock;
                    $idInventario = $model_finded[0]->idInventario;

                    if($model_finded){
                        $data_model3 = Inventario::find($idInventario);
                        $data_model3->Stock = $stockActual - $detalle['Cantidad'];
                        $data_model3->save();
                    }

                    //QUITAR LA VENTA CON SU DETALLE
                    $data_model4 = VentaDetalle::where('idTransaccion', $request->newModel['idTransaccion']);
                    $data_model4->delete();

                    $data_model5 = Venta::find($request->newModel['idTransaccion']);
                    $data_model5->delete();
                }
            }

        DB::commit();
         //return $data_model;
    }catch(\Exception $e){
    // rollback operation for failure
        DB::rollback();
    }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data_model = Venta::find($id);
        $data_model->Descripcion = $request->Descripcion;
        $data_model->Marca = $request->Marca;
        $data_model->idCliente = $request->idCliente;
        $data_model->save();
        return $data_model;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($idCompra)
    {
        $data_model = Venta::find($idCompra);
        $data_model->delete();
    }

    public function ventasJabonBaño()
    {
        $data_model = Venta::select(DB::raw("DATE_FORMAT(venta.Fecha, '%d/%m/%Y') AS FechaESP"), "venta.*", "detalleventa.*","producto.Descripcion", "cliente.Nombre AS NCli")
        ->join("detalleventa","detalleventa.idTransaccion","=","venta.idTransaccion")
        ->join("producto","producto.idProducto","=","detalleventa.idProducto")
        ->join("cliente","cliente.idCliente","=","venta.idCliente")
        ->where("producto.Descripcion","=","Jabon de Baño")->get();

        $pdf = PDF::loadView('ventasJabonBaño', compact('data_model'));
        return $pdf->stream();
     }
}
