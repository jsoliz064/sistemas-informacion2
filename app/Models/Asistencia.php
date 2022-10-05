<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    use HasFactory;
    protected $table = "asistencias";
    protected $guarded = ['id','created_at','updated_at'];
    public function Empleado()
    {
        return  $this->belongsTo('App\Models\Empleado');
    }
}
