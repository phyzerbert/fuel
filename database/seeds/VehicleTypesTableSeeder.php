<?php

use Illuminate\Database\Seeder;
use App\Models\VehicleType;

class VehicleTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        VehicleType::create(['name' => 'TIR']);
        VehicleType::create(['name' => 'KAMYON']);
        VehicleType::create(['name' => 'ESKAVATOR']);
        VehicleType::create(['name' => 'KIRICI']);
        VehicleType::create(['name' => 'DOZER']);
        VehicleType::create(['name' => 'PIKAP']);
        VehicleType::create(['name' => 'OTOMOBIL']);
        VehicleType::create(['name' => 'SUV']);
    }
}
