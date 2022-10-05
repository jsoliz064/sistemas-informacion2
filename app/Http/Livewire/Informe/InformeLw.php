<?php

namespace App\Http\Livewire\Informe;

use Livewire\Component;
use App\Models\Informe;
use App\Models\ClienteServicio;

use Livewire\WithPagination;

class InformeLw extends Component
{
    use WithPagination;
    public $search = "";
    public $cant = 10;
    public $informe=[];
    public $cliente_servicio_id=null;

    public $ordenar='desc';

    public $modalDestroy=false;
    public $modalCrear=false;

    public function amount($cliente_servicio_id){
        $this->cliente_servicio_id=$cliente_servicio_id;
    }
    public function render()
    {
        $informes=Informe::where('cliente_servicio_id',$this->cliente_servicio_id)
        ->orderBy('id', $this->ordenar)
        ->simplePaginate($this->cant);
        $cliente_servicio=ClienteServicio::find($this->cliente_servicio_id);
        return view('livewire.informe.informe-lw',compact('informes','cliente_servicio'));
    }
    public function crear(){
        $this->modalCrear=true;
    }
    public function store()
    {
        $this->validate([
            'informe.name'=>'required',
        ]);
        Informe::create($this->informe);
        $this->limpiar();
    }
    
    public function modalDestroy($id){
        $this->informe['id']=$id;
        $this->modalDestroy=true;
    }

    public function limpiar(){
        $this->informe=[];
        $this->modalDestroy=false;
        $this->modalCrear=false;
    }

    public function cancelar(){
        $this->limpiar();
    }
    public function destroy()
    {
        $informe=Informe::find($this->informe['id']);
        $ruta = "public".$informe->path;
        if (file_exists("../".$ruta)){
            unlink("../".$ruta);
        }
        $informe->delete();
        $this->modalDestroy=false;
    }
}
