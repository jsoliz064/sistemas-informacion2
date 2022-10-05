<?php

namespace Database\Seeders;
use App\Models\User;
use App\Models\Cliente;
use App\Models\Empleado;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'=> 'Administrador',
            'email'=> 'admin@gmail.com',
            'password' => bcrypt('1234'),
        ])->assignRole('Admin');

        $user1 = User::create([
            'name'=> 'Empleado 1',
            'email'=> 'empleado@gmail.com',
            'password' => bcrypt('1234'),
        ])->assignRole('Empleado');

        Empleado::create([
            'name'=>$user1->name,
            'ci'=>"898989",
            'phone'=>"71237123",
            'user_id'=>$user1->id,
            'area_id'=>1,
        ]);

        $user2 = User::create([
            'name'=> 'Cliente 1',
            'email'=> 'cliente@gmail.com',
            'password' => bcrypt('1234'),
        ])->assignRole('Cliente');

        Cliente::create([
            'name'=>$user2->name,
            'ci'=>"898989",
            'phone'=>"71237123",
            'user_id'=>$user2->id,
        ]);
    }
}
