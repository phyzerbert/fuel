<?php

use Illuminate\Database\Seeder;
use App\Models\Fuel;

class FuelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Fuel::create(['name' => 'Gasoline']);
        Fuel::create(['name' => 'Diesel']);
    }
}
