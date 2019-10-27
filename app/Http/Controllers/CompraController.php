<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB; use App\Quotation;
use App\Compra;

class CompraController extends Controller
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

          $data_model = Compra::select(DB::raw("DATE_FORMAT(compra.Fecha, '%d/%m/%Y') AS FechaESP"), "compra.*", "proveedor.Nombre AS NProv", "tipo_pago.Nombre AS NTP")
          ->join("proveedor","proveedor.idProveedor","=","compra.idProveedor")
          ->join("tipo_pago","tipo_pago.idTipoPago","=","compra.idTipoPago")
          ->orderBy('compra.idTransaccion', 'DESC')->paginate(10);

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
        return view('compra');
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
        $request->validate([
            'Fecha' => 'required',
            'Estado' => 'required',
            'idTipoPago' => 'required',
            'idComprador' => 'required',
            'idProveedor' => 'required'
        ]);

        $data_model = new Compra();
        $data_model->Fecha = $request->Fecha;
        $data_model->Estado = $request->Estado;
        $data_model->idTipoPago = $request->idTipoPago;
        $data_model->idComprador = $request->idComprador;
        $data_model->idProveedor = $request->idProveedor;
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
        $data_model = Compra::find($id);
        $data_model->Descripcion = $request->Descripcion;
        $data_model->Marca = $request->Marca;
        $data_model->idProveedor = $request->idProveedor;
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
        $data_model = Compra::find($idCompra);
        $data_model->delete();
    }
}
