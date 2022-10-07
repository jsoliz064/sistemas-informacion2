<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Asistencia;
use Carbon\Carbon;

class Empleado extends Model
{
    use HasFactory;
    protected $table = "empleados";
    protected $guarded = ['id','created_at','updated_at'];
    
    public function User()
    {
        return  $this->belongsTo('App\Models\User');
    }
    public function Area()
    {
        return  $this->belongsTo('App\Models\Area');
    }
    
}
