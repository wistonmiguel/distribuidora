<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB; use App\Quotation;
use App\VentaDevolucion;
//use App\VentaDetalleDevolucion;
//use App\VentaDevolucionDetalle;
use App\Inventario;

class VentaDevolucionController extends Controller
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

          $data_model = VentaDevolucion::select(DB::raw("DATE_FORMAT(dev_venta.Fecha, '%d/%m/%Y') AS FechaESP"), "dev_venta.*", "cliente.Nombre AS NCli", "vendedor.Nombre AS NVend")
          ->join("cliente","cliente.idCliente","=","dev_venta.idCliente")
          ->join("vendedor","vendedor.idVendedor","=","dev_venta.idVendedor")
          ->orderBy('dev_venta.idTransaccion', 'DESC')->paginate(10);

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
        return view('ventasdevolucion');
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

        // Database operations
        $data_model = null;
        $data_model = new VentaDevolucion();
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
        $data_model = VentaDevolucion::find($idTransaccion);
        $data_model->delete();
    }
}
