<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AsistenciaController extends Controller
{
    public function index(){
        return view('cruds.asistencia.index');
    }
    public function reporte(){
        return view('cruds.asistencia.reporte');
    }
}
