<?php

namespace App\Http\Livewire\Cliente;

use Livewire\Component;
use App\Models\ClienteServicio;
use App\Models\Servicio;
use Livewire\WithPagination;

class ServicioLw extends Component
{
    use WithPagination;
    public $search = "";
    public $cant = 10;
    public $clienteservicio=[];
    public $ordenar='desc';

    public $modalDestroy=false;
    public $modalEdit=false;
    public $modalCrear=false;

    public function render()
    {

        if (Auth()->user()->Cliente){
            $cliente_id=Auth()->user()->Cliente->id;
            $cliente_servicios = ClienteServicio::where('cliente_id',$cliente_id)
            ->where('finished',false)
            ->orderBy('id', $this->ordenar)
            ->simplePaginate($this->cant);
        }else{
            $cliente_servicios = ClienteServicio::
            orderBy('id', $this->ordenar)
            ->simplePaginate($this->cant);
        }
        $servicios=Servicio::all();
        $latitude=-17.784514812703144;
        $longitude=-63.18003610135552;
        return view('livewire.cliente.servicio-lw',compact('cliente_servicios','servicios','latitude','longitude'));
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
        $this->servicio['id']=$id;
        $this->modalDestroy=true;
    }
    public function modalEdit($id){
        $this->modalEdit=true;
        $this->servicio=ClienteServicio::find($id)->toArray();
    }

    public function update(){
        $this->validate([
            'servicio.name'=>'required',
            'servicio.area_id'=>'required',
        ]);
        $servicio=ClienteServicio::find($this->servicio['id']);
        $servicio->name=$this->servicio['name'];
        $servicio->area_id=$this->servicio['area_id'];
        $servicio->save();

        $this->limpiar();
    }
    public function limpiar(){
        $this->servicio=[];
        $this->modalEdit=false;
        $this->modalDestroy=false;
        $this->modalCrear=false;
    }

    public function cancelar(){
        $this->limpiar();
    }
    public function destroy()
    {
        $servicio=ClienteServicio::find($this->servicio['id']);
        $servicio->delete();
        $this->modalDestroy=false;
    }
}
