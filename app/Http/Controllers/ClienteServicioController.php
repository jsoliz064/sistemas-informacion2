<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClienteServicioController extends Controller
{
    public function index(){
        return view('cruds.cliente_servicio.index');
    }
}
