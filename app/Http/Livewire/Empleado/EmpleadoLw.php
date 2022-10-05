<?php

namespace App\Http\Livewire\Empleado;

use Livewire\Component;
use App\Models\Empleado;
use App\Models\User;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;

class EmpleadoLw extends Component
{
    use WithPagination;
    public $search = "";
    public $cant = 10;
    public $user=[];
    public $empleado_id=null;
    public $email = null;
    public $ordenar='desc';

    public $modalDestroy=false;
    public $modalEdit=false;
    public $modalCrear=false;

    public function render(){
        $empleados = Empleado::where('name', 'like', '%' . $this->search . '%')
        ->orderBy('id', $this->ordenar)
        ->simplePaginate($this->cant);
        return view('livewire.empleado.empleado-lw',compact('empleados'));
    }
    public function crear(){
        $this->modalCrear=true;
        $this->user['rol_id']=2;
    }
    public function store()
    {
        $this->validate([
            'user.name'=>'required|string|max:255',
            'user.ci'=>'required|string|max:20',
            'user.phone'=>'required|string|max:20',
            'email'=>'required|string|max:255|email|unique:users',
            'user.password'=>'required|string|min:4',
        ]);
        if ($this->user['password']!==$this->user['cpassword']){
            $this->validate([
                'user.password'=>'required|string|min:4|confirmed',
            ]);
        }
        $this->user['email']=$this->email;
        $this->user['password']=Hash::make($this->user['password']);
        $user=User::create($this->user)->assignRole(2);

        Empleado::create([
            'name' => $user->name,
            'ci' => $this->user['ci'],
            'phone' =>$this->user['phone'],
            'user_id' => $user->id,
        ]);

        $this->limpiar();
    }
    
    
    public function modalEdit($id){
        $this->modalEdit=true;
        $this->empleado_id=$id;
        $empleado=Empleado::find($id);
        $this->user=User::find($empleado->user_id)->toArray();

        $this->email=$this->user['email'];
        $this->user['phone']=$empleado->phone;
        $this->user['ci']=$empleado->ci;
        $this->user['password']="";
        $this->user['cpassword']="";
        //$this->user['rol_id']=2;
    }

    public function update(){
        $this->validate([
            'user.name'=>'required|string|max:255',
            'user.ci'=>'required|string|max:20',
            'user.phone'=>'required|string|max:20',
        ]);
        $empleado=Empleado::find($this->empleado_id);
        $user=User::find($this->user['id']);

        if ($this->email!==$user->email){
            $this->validate([
                'email'=>'required|string|max:255|email|unique:users',
            ]);
        }

        if ($this->user['password']){
            if ($this->user['password']!==$this->user['cpassword']){
                $this->validate([
                    'user.password'=>'required|string|min:4|confirmed',
                ]);
            }
            $this->user['password']=Hash::make($this->user['password']);
            $user->password=$this->user['password'];
        }

        $this->user['email']=$this->email;

        $user->name=$this->user['name'];
        $user->email=$this->user['email'];
        //$user->assignRole($this->user['rol_id']);
        $user->save();

        $empleado->name=$this->user['name'];
        $empleado->ci=$this->user['ci'];
        $empleado->phone=$this->user['phone'];
        $empleado->save();

        $this->limpiar();
    }
    public function limpiar(){
        $this->user=[];
        $this->email=null;
        $this->empleado_id=null;
        $this->modalEdit=false;
        $this->modalDestroy=false;
        $this->modalCrear=false;
    }

    public function cancelar(){
        $this->limpiar();
    }

    public function modalDestroy($id){
        $this->empleado_id=$id;
        $this->modalDestroy=true;
    }

    public function destroy()
    {
        $empleado=Empleado::find($this->empleado_id);
        $user=User::find($empleado->user_id);
        $empleado->delete();
        $user->delete();
        $this->modalDestroy=false;
    }
    
}
