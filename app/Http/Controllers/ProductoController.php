<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Producto;
use DB; use App\Quotation;
use App\Inventario;

class ProductoController extends Controller
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

          $data_model = Producto::select("producto.*", "proveedor.Nombre")
          ->join("proveedor","proveedor.idProveedor","=","producto.idProveedor")
          ->orderBy('producto.idProducto', 'DESC')->paginate(10);

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
        return view('producto');
    }
    }

    //FUNCION PARA IMPLEMENTAR
    public function getAll(Request $request)
    {
        if($request->ajax()){
            $data_model = Producto::orderBy('Descripcion', 'ASC')->get();
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
            'Descripcion' => 'required',
            'Marca' => 'required',
            'idProveedor' => 'required'
        ]);

        DB::beginTransaction();
        try{
            $data_model = new Producto();
            $data_model->Descripcion = $request->Descripcion;
            $data_model->Marca = $request->Marca;
            $data_model->Und_Medida = $request->Und_Medida;
            $data_model->Presentacion = $request->Presentacion;
            $data_model->idProveedor = $request->idProveedor;

        if($data_model->save())
            {
                $last_id = $data_model->idProducto;

                $data_model2 = new Inventario();
                $data_model2->Stock = 0;
                $data_model2->idProducto = $last_id;
                $data_model2->idAlmacen = 1;
                $data_model2->save();

                DB::commit();
            }
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
        $data_model = Producto::find($id);
        $data_model->Descripcion = $request->Descripcion;
        $data_model->Marca = $request->Marca;
        $data_model->Und_Medida = $request->Und_Medida;
        $data_model->Presentacion = $request->Presentacion;
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
    public function destroy($idProducto)
    {
        $data_model = Producto::find($idProducto);
        $data_model->delete();
    }
}
