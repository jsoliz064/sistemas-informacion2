<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;
    protected $table = "roles";
    protected $guarded = ['id','created_at','updated_at'];
     /* //Relacion muchos a muchos
     public function permissions(){
        return $this->belongsToMany('App\Models\Permission');
    } */
}
