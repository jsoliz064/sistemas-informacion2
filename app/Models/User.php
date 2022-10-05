<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function Cliente() {
        return $this->hasOne('App\Models\Cliente');
      }
      public function Empleado() {
        return $this->hasOne('App\Models\Empleado');
      }

    public function rol_name() {
        return $this->getRoleNames()[0];
    }
    public function rol_id() {
        $rol = DB::table('roles')
        ->join('model_has_roles', 'role_id', '=', 'roles.id')
        ->join('users', 'users.id', '=', 'model_has_roles.model_id')
        ->where('users.id', '=', $this->id)
        ->select('roles.id')
        ->get()
        ->first();
        return $rol?$rol->id:null;
    }
}
