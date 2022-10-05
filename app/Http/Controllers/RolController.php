<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RolController extends Controller
{
    public function index(){
        return view('cruds.rol.index');
    }
    public function permisos(){
        return view('cruds.rol.permiso');
    }
}
