<?php

namespace App\Http\Livewire\Asistencia;

use Livewire\Component;
use App\Models\Asistencia;
use App\Models\Empleado;
use Livewire\WithPagination;
use Carbon\Carbon;

class AsistenciaLw extends Component
{
    use WithPagination;
    public $search = "";
    public $cant = 10;
    public $ordenar='desc';

    public function render()
    {
        $empleados = Empleado::where('name', 'like', '%' . $this->search . '%')
        ->orderBy('id', $this->ordenar)
        ->simplePaginate($this->cant);
        return view('livewire.asistencia.asistencia-lw',compact('empleados'));
    }
    
    public function empezar($empleado_id)
    {
        date_default_timezone_set("America/La_Paz");
        $hoy=new Carbon();
        Asistencia::create([
            'begin' =>$hoy,
            'empleado_id'=>$empleado_id,
        ]);
    }
    public function terminar($empleado_id)
    {
        date_default_timezone_set("America/La_Paz");
        $hoy=new Carbon();
        $asistencia=Asistencia::where('empleado_id',$empleado_id)->orderBy('id', 'DESC')->get()->first();
        $asistencia->update([
            'end' =>$hoy,
        ]);
    }
    public function verificar($empleado_id){
        $asistencia=Asistencia::where('empleado_id',$empleado_id)->orderBy('id','DESC')->get()->first();
        date_default_timezone_set("America/La_Paz");
        $hoy=new Carbon();
        if ($asistencia==null){
            return 1;
        }
        $begin=new Carbon($asistencia->begin);
        if ($begin!=null && $asistencia->end!=null && $begin->format('Y-m-d')!=$hoy->format('Y-m-d')){
            return 1;
        }
        if ($begin->format('Y-m-d')!=$hoy->format('Y-m-d') && $asistencia->end==null){
            return 1;
        }
        if ($begin->format('Y-m-d')==$hoy->format('Y-m-d') && $asistencia->end==null){
            return 2;
        }
        return 3;
    }
    
    
}
