<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use App\Models\Rol;
use Livewire\WithPagination;

class RolLw extends Component
{
    
    use WithPagination;
    public $search = "";
    public $cant = 10;
    public $rol=[];
    public $ordenar='desc';

    public $modalDestroy=false;
    public $modalEdit=false;
    public $modalCrear=false;

    public function render()
    {
        $rols = Rol::where('name', 'like', '%' . $this->search . '%')
            ->orderBy('id', $this->ordenar)
            ->simplePaginate($this->cant);
        return view('livewire.user.rol-lw',compact('rols'));
    }
    public function crear(){
        $this->modalCrear=true;
    }
    public function store()
    {
        $this->validate([
            'rol.name'=>'required',
        ]);
        $this->rol['guard_name']="web";
        Rol::create($this->rol);
        $this->limpiar();
    }
    
    public function modalDestroy($id){
        $this->rol['id']=$id;
        $this->modalDestroy=true;
    }
    public function modalEdit($id){
        $this->modalEdit=true;
        $this->rol=Rol::find($id)->toArray();
    }

    public function update(){
        $this->validate([
            'rol.name'=>'required',
        ]);
        $rol=Rol::find($this->rol['id']);
        $rol->name=$this->rol['name'];
        $rol->save();

        $this->limpiar();
    }
    public function limpiar(){
        $this->rol=[];
        $this->modalEdit=false;
        $this->modalDestroy=false;
        $this->modalCrear=false;
    }

    public function cancelar(){
        $this->limpiar();
    }
    public function destroy()
    {
        $rol=Rol::find($this->rol['id']);
        $rol->delete();
        $this->modalDestroy=false;
    }
}
