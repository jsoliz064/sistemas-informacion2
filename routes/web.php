<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\ClienteServicioController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\PagoController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::group(['prefix'=> 'users'], function () {
        Route::get('index',[UserController::class,'users'])->name('users.index');
        Route::get('roles',[RolController::class,'index'])->name('roles.index');
        Route::get('permisos',[RolController::class,'permisos'])->name('permisos.index');

    });
});

Route::get('users',[UserController::class,'index'])->name('user.index');
Route::get('empleados',[EmpleadoController::class,'index'])->name('empleado.index');
Route::get('clientes',[ClienteController::class,'index'])->name('cliente.index');
Route::get('clientesServicios',[ClienteController::class,'servicio'])->name('cliente.servicio');
Route::post('clientesServicios/store',[ClienteController::class,'store'])->name('cliente.servicio.store');
Route::delete('clientesServicios/delete/{cliente_servicio}',[ClienteController::class,'destroy'])->name('cliente.servicio.destroy');

Route::get('areas',[AreaController::class,'index'])->name('area.index');
Route::get('servicios',[ServicioController::class,'index'])->name('servicio.index');
Route::get('pagos',[PagoController::class,'index'])->name('pago.index');
Route::get('solicitudes',[ClienteServicioController::class,'index'])->name('solicitudes.index');





