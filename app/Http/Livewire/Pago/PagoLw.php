<?php

namespace App\Http\Livewire\Pago;

use Livewire\Component;
use App\Models\Pago;
use App\Models\Empleado;
use App\Models\User;
use Livewire\WithPagination;

class PagoLw extends Component
{
    use WithPagination;
    public $search = "";
    public $cant = 10;
    public $pago=[];
    public $ordenar='desc';

    public $modalDestroy=false;
    public $modalEdit=false;
    public $modalCrear=false;

    public function render()
    {
        $user=User::find(Auth()->user()->id);
        if ($user->rol_id()==1){
            $pagos = Pago::orderBy('id', $this->ordenar)
            ->simplePaginate($this->cant);
        }else{
            $pagos = Pago::where('empleado_id',$user->Empleado->id)
            ->orderBy('id', $this->ordenar)
            ->simplePaginate($this->cant);
        }
        $empleados=Empleado::all();
        return view('livewire.pago.pago-lw',compact('pagos','empleados'));
    }
    public function crear(){
        $this->modalCrear=true;
    }
    public function store()
    {
        $this->validate([
            'pago.description'=>'required',
            'pago.amount'=>'required',
            'pago.empleado_id'=>'required',
        ]);
        date_default_timezone_set("America/La_Paz");
        Pago::create($this->pago);
        $this->limpiar();
    }
    
    public function modalDestroy($id){
        $this->pago['id']=$id;
        $this->modalDestroy=true;
    }
    public function modalEdit($id){
        $this->modalEdit=true;
        $this->pago=Pago::find($id)->toArray();
    }

    public function update(){
        $this->validate([
            'pago.description'=>'required',
            'pago.amount'=>'required',
            'pago.empleado_id'=>'required',
        ]);
        $pago=Pago::find($this->pago['id']);
        $pago->description=$this->pago['description'];
        $pago->amount=$this->pago['amount'];
        $pago->empleado_id=$this->pago['empleado_id'];
        $pago->save();

        $this->limpiar();
    }
    public function limpiar(){
        $this->pago=[];
        $this->modalEdit=false;
        $this->modalDestroy=false;
        $this->modalCrear=false;
    }

    public function cancelar(){
        $this->limpiar();
    }
    public function destroy()
    {
        $pago=Pago::find($this->pago['id']);
        $pago->delete();
        $this->modalDestroy=false;
    }
}
