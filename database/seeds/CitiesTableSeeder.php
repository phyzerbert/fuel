<?php

use Illuminate\Database\Seeder;
use App\Models\City;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        City::create(['name' => 'Istanbul']);
        City::create(['name' => 'Ankara']);
        City::create(['name' => 'Izmir']);
        City::create(['name' => 'Bursa']);
        City::create(['name' => 'Adana']);
    }
}
