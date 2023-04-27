<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $user2 = User::create([
            'name' => 'alan',
            'email' => 'enriquezalan52@gmail.com',//admin
            'password' => bcrypt('12345678'),
            'rol_id' => 1,
        ]);

        $user3 = User::create([
            'name' => 'david',
            'email' => 'ealan9957@gmail.com',//supervisor
            'password' => bcrypt('12345678'),
            'rol_id' => 2,
        ]);

        $user = User::create([
            'name' => 'enriquez',
            'email' => 'barrientosaland6@gmail.com',//usuario mortal
            'password' => bcrypt('12345678'),
            'rol_id' => 3,
        ]);
    }
}
