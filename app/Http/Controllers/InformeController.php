<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Informe;

class InformeController extends Controller
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
    public function index()
    {
        return view('informe');
    }

    //FUNCION PARA IMPLEMENTAR
    public function getAll(Request $request)
    {
        /*
            $data_model = Informe::orderBy('Nombre', 'ASC')->get();
            return [
                'model' => $data_model
            ];
        */
    }
}
