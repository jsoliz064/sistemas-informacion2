<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;


use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role1 = Role::create(['name' => 'Admin']);
        $role2 = Role::create(['name' => 'Empleado']);
        $role3 = Role::create(['name' => 'Cliente']);

        Permission::create(['name'=>'admin'])->syncRoles([$role1]);
        Permission::create(['name'=>'empleado'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'cliente'])->syncRoles([$role1,$role3]);

    } 
}
