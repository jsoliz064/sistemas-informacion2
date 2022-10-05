<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Rol;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class UserLw extends Component
{
    use WithPagination;
    public $search = "";
    public $cant = 10;
    public $user=[];
    public $email = null;
    public $ordenar='desc';

    public $modalDestroy=false;
    public $modalEdit=false;
    public $modalCrear=false;

    public function render()
    {
         $users = User::where('name', 'like', '%' . $this->search . '%')
            ->orderBy('id', $this->ordenar)
            ->simplePaginate($this->cant);
        $rols=Rol::all();
        return view('livewire.user.user-lw',compact('users','rols'));
    }
    public function crear(){
        $this->modalCrear=true;
    }
    public function store()
    {
        $this->validate([
            'user.name'=>'required|string|max:255',
            'email'=>'required|string|max:255|email|unique:users',
            'user.password'=>'required|string|min:4',
            'user.rol_id'=>'required',
        ]);
        if ($this->user['password']!==$this->user['cpassword']){
            $this->validate([
                'user.password'=>'required|string|min:4|confirmed',
            ]);
        }
        $this->user['email']=$this->email;
        $this->user['password']=Hash::make($this->user['password']);
        $this->user['accessToken']=Str::uuid();
        $user=User::create($this->user);
        $user->roles()->sync($this->user['rol_id']);
        $this->limpiar();
    }
    
    public function modalDestroy($id){
        $this->user['id']=$id;
        $this->modalDestroy=true;
    }
    public function modalEdit($id){
        $this->modalEdit=true;
        $user=User::find($id);
        $this->user=User::find($id)->toArray();
        $this->email=$this->user['email'];
        $this->user['password']="";
        $this->user['cpassword']="";
        $this->user['rol_id']=$user->rol_id();
    }

    public function update(){
        $this->validate([
            'user.name'=>'required|string|max:255',
            'user.rol_id'=>'required',
        ]);
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
        $user->roles()->sync($this->user['rol_id']);
        $user->save();

        $this->limpiar();
    }
    public function limpiar(){
        $this->user=[];
        $this->email=null;
        $this->modalEdit=false;
        $this->modalDestroy=false;
        $this->modalCrear=false;
    }

    public function cancelar(){
        $this->limpiar();
    }
    public function destroy()
    {
        $user=User::find($this->user['id']);
        $user->delete();
        $this->modalDestroy=false;
    }
}
