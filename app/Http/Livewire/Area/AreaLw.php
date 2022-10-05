<?php

namespace App\Http\Livewire\Area;

use Livewire\Component;
use App\Models\Area;
use Livewire\WithPagination;

class AreaLw extends Component
{
    use WithPagination;
    public $search = "";
    public $cant = 10;
    public $area=[];
    public $ordenar='desc';

    public $modalDestroy=false;
    public $modalEdit=false;
    public $modalCrear=false;
    public function render()
    {
        
        $areas = Area::where('name', 'like', '%' . $this->search . '%')
            ->orderBy('id', $this->ordenar)
            ->simplePaginate($this->cant);
        return view('livewire.area.area-lw',compact('areas'));
    }
    public function crear(){
        $this->modalCrear=true;
    }
    public function store()
    {
        $this->validate([
            'area.name'=>'required',
        ]);
        Area::create($this->area);
        $this->limpiar();
    }
    
    public function modalDestroy($id){
        $this->area['id']=$id;
        $this->modalDestroy=true;
    }
    public function modalEdit($id){
        $this->modalEdit=true;
        $this->area=Area::find($id)->toArray();
    }

    public function update(){
        $this->validate([
            'area.name'=>'required',
        ]);
        $area=Area::find($this->area['id']);
        $area->name=$this->area['name'];
        $area->save();

        $this->limpiar();
    }
    public function limpiar(){
        $this->area=[];
        $this->modalEdit=false;
        $this->modalDestroy=false;
        $this->modalCrear=false;
    }

    public function cancelar(){
        $this->limpiar();
    }
    public function destroy()
    {
        $area=Area::find($this->area['id']);
        $area->delete();
        $this->modalDestroy=false;
    }
}
