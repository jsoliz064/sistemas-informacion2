<?php

namespace App\Http\Livewire\ClienteServicio;

use Livewire\Component;
use App\Models\ClienteServicio;
use App\Models\Empleado;
use App\Models\User;
use Livewire\WithPagination;

class ClienteServicioLw extends Component
{
    use WithPagination;
    public $search = "";
    public $cant = 10;
    public $cliente_servicio=[];
    public $ordenar='desc';

    public $modalDestroy=false;
    public $modalEdit=false;
    public $modalCrear=false;

    public function render()
    {
        $user=User::find(Auth()->user()->id);
        if ($user->rol_id()==1){
            $cliente_servicios = ClienteServicio::orderBy('id', $this->ordenar)
            ->simplePaginate($this->cant);
        }else{
            $cliente_servicios = ClienteServicio::where('empleado_id',$user->Empleado->id)
            ->orderBy('id', $this->ordenar)
            ->simplePaginate($this->cant);
        }
        $empleados=Empleado::all();
        return view('livewire.cliente-servicio.cliente-servicio-lw',compact('cliente_servicios','empleados'));
    }
    public function crear(){
        $this->modalCrear=true;
    }
    public function store()
    {
        $this->validate([
            'servicio.name'=>'required',
            'servicio.area_id'=>'required',
        ]);
        ClienteServicio::create($this->servicio);
        $this->limpiar();
    }
    
    public function modalDestroy($id){
        $this->cliente_servicio['id']=$id;
        $this->modalDestroy=true;
    }
    public function modalEdit($id){
        $this->modalEdit=true;
        $this->cliente_servicio=ClienteServicio::find($id)->toArray();
    }

    public function update(){
        $this->validate([
            'cliente_servicio.empleado_id'=>'required',
        ]);
        $cliente_servicio=ClienteServicio::find($this->cliente_servicio['id']);
        $cliente_servicio->empleado_id=$this->cliente_servicio['empleado_id'];
        $cliente_servicio->accepted=true;
        $cliente_servicio->save();

        $this->limpiar();
    }
    public function limpiar(){
        $this->cliente_servicio=[];
        $this->modalEdit=false;
        $this->modalDestroy=false;
        $this->modalCrear=false;
    }

    public function cancelar(){
        $this->limpiar();
    }
    public function destroy()
    {
        $cliente_servicio=ClienteServicio::find($this->cliente_servicio['id']);
        $cliente_servicio->delete();
        $this->modalDestroy=false;
    }
}
