<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
class ClienteController extends Controller
{
    public function index()
    {
        return view('cruds.cliente.index');
    }
    
    public function servicio()
    {
        return view('cruds.cliente.servicios');
    }
}
