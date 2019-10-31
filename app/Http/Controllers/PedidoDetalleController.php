<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PedidoDetalle;
//use App\Proveedor;

class PedidoDetalleController extends Controller
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
          $data_model = PedidoDetalle::select("detallepedido.*", "producto.Descripcion")
          ->join("producto","producto.idProducto","=","detallepedido.idProducto")
          ->orderBy('detallepedido.idDetalle', 'DESC')->paginate(10);

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

    //FUNCION PARA IMPLEMENTAR
    public function getAll(Request $request)
    {
        if($request->ajax()){
            $data_model = PedidoDetalle::select("detallepedido.*", "producto.Descripcion")
            ->join("producto","producto.idProducto","=","detallepedido.idProducto")
            ->where('detallepedido.idTransaccion', "=", $request->id)
            ->orderBy('detallepedido.idDetalle', 'DESC')->get();
            return [
                'model' => $data_model
            ];
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
            'Descripcion' => 'required',
            'Marca' => 'required',
            'idProveedor' => 'required'
        ]);
        */

        $data_model = null;
        $data_model = new PedidoDetalle();
        $data_model->idProducto = $request->idProducto;
        $data_model->idTransaccion = $request->idTransaccion;
        $data_model->Cantidad = $request->Cantidad;
        $data_model->Precio = $request->Precio;
        $data_model->save();

        return $data_model;
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
        $data_model = PedidoDetalle::find($id);
        $data_model->idProducto = $request->idProducto;
        $data_model->idTransaccion = $request->idTransaccion;
        $data_model->Cantidad = $request->Cantidad;
        $data_model->Precio = $request->Precio;
        $data_model->save();
        return $data_model;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($idDetalle)
    {
        $data_model = PedidoDetalle::find($idDetalle);
        $data_model->delete();
    }
}
