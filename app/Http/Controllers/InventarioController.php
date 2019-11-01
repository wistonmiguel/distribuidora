<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inventario;
use DB; use App\Quotation;

class InventarioController extends Controller
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
          $data_model = Inventario::select("inventario.*", "producto.Descripcion", "almacen.Nombre")
          ->join("producto","producto.idProducto","=","inventario.idProducto")
          ->join("almacen","almacen.idAlmacen","=","inventario.idAlmacen")
          ->orderBy('inventario.idInventario', 'DESC')->paginate(10);

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
        return view('inventario');
    }
    }

    //FUNCION PARA IMPLEMENTAR
    public function getAll(Request $request)
    {
        if($request->ajax()){
            $data_model = Inventario::select("inventario.idInventario", "inventario.Stock", "inventario.idProducto", "producto.Descripcion")
            ->join("producto","producto.idProducto","=","inventario.idProducto")
            ->orderBy('producto.Descripcion', 'DESC')->get(10);
            return [
                'model' => $data_model
            ];
    }
    }

    //FUNCION PARA IMPLEMENTAR
    public function checkStock(Request $request)
    {
        if($request->ajax()){
            $data_model = Inventario::select("inventario.Stock")
            ->where("inventario.idProducto","=", $request->idProducto)->get();
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
        $request->validate([
            'Stock' => 'required',
            'idProducto' => 'required',
            'idAlmacen' => 'required'
        ]);

        $model_finded = Inventario::select("inventario.idInventario", "inventario.Stock")->where("inventario.idProducto", "=", $request->idProducto)->get();
        $stockActual = $model_finded[0]->Stock;
        $idInventario = $model_finded[0]->idInventario;

        if($model_finded){
            $data_model = Inventario::find($idInventario);
            $data_model->Stock = $stockActual + $request->Stock;
            $data_model->save();
        }
        else
        {
            $data_model = null;
            $data_model = new Inventario();
            $data_model->Stock = $request->Stock;
            $data_model->idProducto = $request->idProducto;
            $data_model->idAlmacen = $request->idAlmacen;
            $data_model->save();
        }
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
        $data_model = Inventario::find($id);
        $data_model->Stock = $request->Stock;
        $data_model->idProducto = $request->idProducto;
        $data_model->idAlmacen = $request->idAlmacen;
        $data_model->save();
        return $data_model;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($idInventario)
    {
        $data_model = Inventario::find($idInventario);
        $data_model->delete();
    }
}
