<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Rol;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rol = new Rol();
        $rol->rol = "admin";
        $rol->save();

        $rol2 = new Rol();
        $rol2->rol = "supervisor";
        $rol2->save();

        $rol3 = new Rol();
        $rol3->rol = "empleado";
        $rol3->save();
    }
}
