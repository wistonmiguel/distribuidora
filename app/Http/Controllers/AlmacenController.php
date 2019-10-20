<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Almacen;

class AlmacenController extends Controller
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
        //return Almacen::all();
        /*
        if($request->ajax()){
            return Almacen::all();
        }else{
            return view('almacen');
        }
        */
        if($request->ajax()){
        $almacen = Almacen::orderBy('idAlmacen', 'DESC')->paginate(3);
        return [
            'pagination' => [
                'total'         => $almacen->total(),
                'current_page'  => $almacen->currentPage(),
                'per_page'      => $almacen->perPage(),
                'last_page'     => $almacen->lastPage(),
                'from'          => $almacen->firstItem(),
                'to'            => $almacen->lastItem(),
            ],
            'almacen' => $almacen
        ];
    }
    else
    {
        return view('almacen');
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
        $almacen = new Almacen();
        $almacen->nombre = $request->nombre;
        $almacen->save();

        return $almacen;
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
        $almacen = Almacen::find($id);
        $almacen->nombre = $request->nombre;
        $almacen->save();
        return $almacen;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($idAlmacen)
    {
        $almacen = Almacen::find($idAlmacen);
        $almacen->delete();
    }
}
