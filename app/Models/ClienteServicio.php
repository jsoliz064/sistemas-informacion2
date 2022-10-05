<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteServicio extends Model
{
    use HasFactory;
    protected $table = "cliente_servicio";
    protected $guarded = ['id','created_at','updated_at'];
    public function Servicio()
    {
        return  $this->belongsTo('App\Models\Servicio');
    }
    public function Cliente()
    {
        return  $this->belongsTo('App\Models\Cliente');
    }
    public function Empleado()
    {
        return  $this->belongsTo('App\Models\Empleado');
    }
}
