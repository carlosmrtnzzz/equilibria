<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Elimina si ya existe
        User::where('email', 'admin@equilibria.com')->delete();

        // Crea desde cero
        $admin = new User();
        $admin->name = 'Admin';
        $admin->email = 'admin@equilibria.com';
        $admin->password = bcrypt('Admin123');
        $admin->is_admin = true;
        $admin->age = 30;
        $admin->gender = 'male';
        $admin->weight_kg = 70;
        $admin->height_cm = 175;
        $admin->save();
    }
}
