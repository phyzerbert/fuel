<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        // $this->call(UnitsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(VehicleTypesTableSeeder::class);
        $this->call(CitiesTableSeeder::class);
        $this->call(FuelsTableSeeder::class);
    }
}
