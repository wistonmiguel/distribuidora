<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB; use App\Quotation;
use App\Pedido;
//use App\PedidoDetalle;

class PedidoController extends Controller
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

          $data_model = Pedido::select(DB::raw("DATE_FORMAT(pedido.Fecha, '%d/%m/%Y') AS FechaESP"), "pedido.*", "cliente.Nombre AS NCli")
          ->join("cliente","cliente.idCliente","=","pedido.idCliente")
          ->orderBy('pedido.idTransaccion', 'DESC')->paginate(10);

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
        return view('pedido');
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
            'idCliente' => 'required'
        ]);
        */

    DB::beginTransaction();

    try{
        // Database operations
        $data_model = new Pedido();
        $data_model->Fecha = $request->newModel['Fecha'];
        $data_model->Estado = $request->newModel['Estado'];
        $data_model->idCliente = $request->newModel['idCliente'];

        if($data_model->save())
            {
                $last_id = $data_model->idTransaccion;

                //GUARDAR DETALLE
                foreach ($request->newModel2 as $detalle) {
                    //echo $detalle['idProducto']." con idTransaccion: ".$last_id." <br>";
                    $data_model2 = null;
                    $data_model2 = new PedidoDetalle();
                    $data_model2->idProducto = $detalle['idProducto'];
                    $data_model2->idTransaccion = $last_id;
                    $data_model2->Cantidad = $detalle['Cantidad'];
                    $data_model2->Precio = $detalle['Precio'];
                    $data_model2->save();
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($idPedido)
    {
        $data_model = Pedido::find($idPedido);
        $data_model->delete();
    }
}
