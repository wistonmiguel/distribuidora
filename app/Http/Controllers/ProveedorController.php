<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proveedor;

class ProveedorController extends Controller
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
            $data_model = Proveedor::orderBy('idProveedor', 'DESC')->paginate(3);

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
        return view('proveedor');
    }
    }

    //FUNCION PARA IMPLEMENTAR
    public function getAll(Request $request)
    {
        if($request->ajax()){
            $data_model = Proveedor::orderBy('Nombre', 'ASC')->get();
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
            'Nombre' => 'required'
        ]);

        $data_model = new Proveedor();
        $data_model->Nombre = $request->Nombre;
        $data_model->Telefono = $request->Telefono;
        $data_model->Direccion = $request->Direccion;
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
        $data_model = Proveedor::find($id);
        $data_model->Nombre = $request->Nombre;
        $data_model->Telefono = $request->Telefono;
        $data_model->Direccion = $request->Direccion;
        $data_model->save();
        return $data_model;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($idProveedor)
    {
        $data_model = Proveedor::find($idProveedor);
        $data_model->delete();
    }
}
