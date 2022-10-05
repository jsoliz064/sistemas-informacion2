<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Area;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Area::create(['name' =>"Area 1"]);
        Area::create(['name' =>"Area 2"]);
        Area::create(['name' =>"Area 3"]);

    }
}
