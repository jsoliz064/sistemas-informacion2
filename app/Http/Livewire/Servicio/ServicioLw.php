<?php

namespace App\Http\Livewire\Servicio;

use Livewire\Component;
use App\Models\Servicio;
use App\Models\Area;
use Livewire\WithPagination;

class ServicioLw extends Component
{
    use WithPagination;
    public $search = "";
    public $cant = 10;
    public $servicio=[];
    public $ordenar='desc';

    public $modalDestroy=false;
    public $modalEdit=false;
    public $modalCrear=false;

    public function render()
    {
        $servicios = Servicio::where('name', 'like', '%' . $this->search . '%')
        ->orderBy('id', $this->ordenar)
        ->simplePaginate($this->cant);
        $areas=Area::all();
        return view('livewire.servicio.servicio-lw',compact('servicios','areas'));
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
        Servicio::create($this->servicio);
        $this->limpiar();
    }
    
    public function modalDestroy($id){
        $this->servicio['id']=$id;
        $this->modalDestroy=true;
    }
    public function modalEdit($id){
        $this->modalEdit=true;
        $this->servicio=Servicio::find($id)->toArray();
    }

    public function update(){
        $this->validate([
            'servicio.name'=>'required',
            'servicio.area_id'=>'required',
        ]);
        $servicio=Servicio::find($this->servicio['id']);
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
        $servicio=Servicio::find($this->servicio['id']);
        $servicio->delete();
        $this->modalDestroy=false;
    }
}
