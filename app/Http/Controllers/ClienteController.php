<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClienteServicio;
use App\Models\Servicio;

class ClienteController extends Controller
{
    public function index()
    {
        return view('cruds.cliente.index');
    }
    
    public function servicio()
    {
        if (Auth()->user()->Cliente){
            $cliente_id=Auth()->user()->Cliente->id;
            $cliente_servicios = ClienteServicio::where('cliente_id',$cliente_id)
            ->where('finished',false)
            ->orderBy('id', 'DESC')
            ->get();
        }else{
            $cliente_servicios = ClienteServicio::all();
        }
        $servicios=Servicio::all();
        $latitude=-17.784514812703144;
        $longitude=-63.18003610135552;
        return view('cruds.cliente.servicios',compact('cliente_servicios','servicios','latitude','longitude'));
    }
    public function store(Request $request){
        $request->validate([
            'servicio_id' => 'required',
            'longitud' =>'required',
            'latitud' =>'required',
        ]);
        if (Auth()->user()->Cliente==null){
            return redirect()->route('cliente.servicio');
        }
        date_default_timezone_set("America/La_Paz");
        $cliente_id=Auth()->user()->Cliente->id;
        ClienteServicio::create([
            'servicio_id' =>$request->servicio_id,
            'cliente_id' =>$cliente_id,
            'longitud' =>$request->longitud,
            'latitud' =>$request->latitud
        ]);
        return redirect()->route('cliente.servicio');
    }
    public function destroy(ClienteServicio $cliente_servicio) {
        $cliente_servicio->delete();
        return redirect()->route('cliente.servicio');
    }
}
