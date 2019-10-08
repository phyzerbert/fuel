<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'admin1',
            'password' => bcrypt('123456'),
            'role_id' => 1,
        ]);
        User::create([
            'name' => 'user1',
            'password' => bcrypt('123456'),
            'role_id' => 2,
            'unit_id' => 1,
        ]);
        User::create([
            'name' => 'user2',
            'password' => bcrypt('123456'),
            'role_id' => 2,
            'unit_id' => 2,
        ]);
    }
}
