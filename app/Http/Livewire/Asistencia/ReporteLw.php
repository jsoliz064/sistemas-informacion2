<?php

namespace App\Http\Livewire\Asistencia;

use Livewire\Component;
use App\Models\Asistencia;
use App\Models\Empleado;

use Livewire\WithPagination;

class ReporteLw extends Component
{
    use WithPagination;
    public $search = "";
    public $cant = 10;
    public $loan=[];
    public $ordenar='desc';
    public $pagado=0;
    public $file;
    public $datein = null;
    public $dateout = null;
    public $empleado_id =null;

    public $modalDestroy=false;
    public $modalEdit=false;
    public $modalCrear=false;

    public function render()
    {
        date_default_timezone_set("America/La_Paz");
        if ($this->datein==null || $this->dateout==null){
            if ($this->empleado_id){
                $asistencias = Asistencia::where('empleado_id',$this->empleado_id)
                ->orderBy('id', $this->ordenar)
                ->simplePaginate($this->cant);
            }else{
                $asistencias = Asistencia::orderBy('id', $this->ordenar)
                ->simplePaginate($this->cant);
            }
        }else{
            $fi=$this->datein.' 00:00:00';
            $ff=$this->dateout.' 23:59:59';
            if ($this->empleado_id){
                $asistencias = Asistencia::whereBetween('begin',[$fi,$ff])
                    ->where('empleado_id',$this->empleado_id)
                    ->orderBy('id', $this->ordenar)
                    ->simplePaginate($this->cant);
            }else{
                $asistencias = Asistencia::whereBetween('begin',[$fi,$ff])
                ->orderBy('id', $this->ordenar)
                ->simplePaginate($this->cant);
            }
        }
        $empleados = Empleado::all();
        return view('livewire.asistencia.reporte-lw',compact('asistencias','empleados'));
    }
}
