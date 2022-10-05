<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClienteServicio;
use App\Models\Informe;
use Illuminate\Support\Facades\Storage;

class InformeController extends Controller
{
    public function store(Request $request, ClienteServicio $cliente_servicio){
        $request->validate([
            'description'=>'required',
            'archivo'=>'required'
        ]);
        $dir="documents/";
        $imageName="informe" . uniqid() . "." . $request->archivo->extension();
        if (!Storage::disk('public')->exists($dir)){
            Storage::disk('public')->makeDirectory($dir);
        }
        Storage::disk('public')->put($dir.$imageName,file_get_contents($request->archivo));
               
        Informe::create([
            'description' =>$request->description,
            'cliente_servicio_id' =>$cliente_servicio->id,
            'path'=>"/storage/documents/${imageName}"
        ]);
        return redirect()->route('solicitudes.show',$cliente_servicio);
    }
}
