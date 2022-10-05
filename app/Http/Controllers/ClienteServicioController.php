<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClienteServicio;

class ClienteServicioController extends Controller
{
    public function index(){
        return view('cruds.cliente_servicio.index');
    }
    public function show(ClienteServicio $cliente_servicio){
        $latitude=-17.784514812703144;
        $longitude=-63.18003610135552;
        $markers=array();
        $dato=array(
            'latitude'=>$cliente_servicio->latitud,
            'longitude'=>$cliente_servicio->longitud,
            'name'=>$cliente_servicio->Cliente->name
        );
        array_push($markers,$dato);
        
        return view('cruds.cliente_servicio.show',compact('cliente_servicio','latitude','longitude','markers'));
    }
}
