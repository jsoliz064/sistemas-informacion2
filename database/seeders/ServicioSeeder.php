<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Servicio;

class ServicioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Servicio::create(['name' =>"servicio 1",'area_id'=>1]);
        Servicio::create(['name' =>"servicio 2",'area_id'=>1]);
        Servicio::create(['name' =>"servicio 3",'area_id'=>2]);
    }
}
