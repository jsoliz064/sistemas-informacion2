<?php

namespace App\Http\Livewire\Cliente;

use Livewire\Component;
use App\Models\Cliente;
use App\Models\User;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;

class ClienteLw extends Component
{
    use WithPagination;
    public $search = "";
    public $cant = 10;
    public $user=[];
    public $cliente_id=null;
    public $email = null;
    public $ordenar='desc';

    public $modalDestroy=false;
    public $modalEdit=false;
    public $modalCrear=false;

    public function render()
    {
        $clientes = Cliente::where('name', 'like', '%' . $this->search . '%')
        ->orderBy('id', $this->ordenar)
        ->simplePaginate($this->cant);
        return view('livewire.cliente.cliente-lw',compact('clientes'));
    }
    public function crear(){
        $this->modalCrear=true;
        $this->user['rol_id']=3;
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
        $user=User::create($this->user)->assignRole(3);

        Cliente::create([
            'name' => $user->name,
            'ci' => $this->user['ci'],
            'phone' =>$this->user['phone'],
            'user_id' => $user->id,
        ]);

        $this->limpiar();
    }
    
    
    public function modalEdit($id){
        $this->modalEdit=true;
        $this->cliente_id=$id;
        $cliente=Cliente::find($id);
        $this->user=User::find($cliente->user_id)->toArray();

        $this->email=$this->user['email'];
        $this->user['phone']=$cliente->phone;
        $this->user['ci']=$cliente->ci;
        $this->user['password']="";
        $this->user['cpassword']="";
    }

    public function update(){
        $this->validate([
            'user.name'=>'required|string|max:255',
            'user.ci'=>'required|string|max:20',
            'user.phone'=>'required|string|max:20',
        ]);
        $cliente=Cliente::find($this->cliente_id);
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
        $user->save();

        $cliente->name=$this->user['name'];
        $cliente->ci=$this->user['ci'];
        $cliente->phone=$this->user['phone'];
        $cliente->save();

        $this->limpiar();
    }
    public function limpiar(){
        $this->user=[];
        $this->email=null;
        $this->cliente_id=null;
        $this->modalEdit=false;
        $this->modalDestroy=false;
        $this->modalCrear=false;
    }

    public function cancelar(){
        $this->limpiar();
    }

    public function modalDestroy($id){
        $this->cliente_id=$id;
        $this->modalDestroy=true;
    }

    public function destroy()
    {
        $cliente=Cliente::find($this->cliente_id);
        $user=User::find($cliente->user_id);
        $cliente->delete();
        $user->delete();
        $this->modalDestroy=false;
    }
    
}
