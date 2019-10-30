<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB; use App\Quotation;
use App\CompraDevolucion;
//use App\CompraDevolucionDetalle;
use App\Inventario;

class CompraDevolucionController extends Controller
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

          $data_model = CompraDevolucion::select(DB::raw("DATE_FORMAT(dev_compra.Fecha, '%d/%m/%Y') AS FechaESP"), "dev_compra.*", "proveedor.Nombre AS NProv", "comprador.Nombre AS NCompr")
          ->join("proveedor","proveedor.idProveedor","=","dev_compra.idProveedor")
          ->join("comprador","comprador.idComprador","=","dev_compra.idComprador")
          ->orderBy('dev_compra.idTransaccion', 'DESC')->paginate(10);

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
        return view('comprasdevolucion');
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
            'idComprador' => 'required',
            'idProveedor' => 'required'
        ]);
        */

    DB::beginTransaction();

    try{
        // Database operations
        $data_model = new CompraDevolucion();
        $data_model->Fecha = $request->newModel['Fecha'];
        $data_model->Estado = $request->newModel['Estado'];
        $data_model->idComprador = $request->newModel['idComprador'];
        $data_model->idProveedor = $request->newModel['idProveedor'];

        if($data_model->save())
            {
                $last_id = $data_model->idTransaccion;

                //GUARDAR DETALLE
                foreach ($request->newModel2 as $detalle) {
                    $data_model2 = null;
                    $data_model2 = new CompraDevolucionDetalle();
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
        // TODO
        /*
        $data_model = CompraDevolucion::find($id);
        $data_model->Descripcion = $request->Descripcion;
        $data_model->Marca = $request->Marca;
        $data_model->idProveedor = $request->idProveedor;
        $data_model->save();
        return $data_model;
        */
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($idTransaccion)
    {
        $data_model = Compra::find($idTransaccion);
        $data_model->delete();
    }
}
