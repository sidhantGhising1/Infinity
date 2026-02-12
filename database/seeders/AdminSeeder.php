<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // -----------------------------
        // SUPER ADMIN
        // -----------------------------
        $superAdmin = User::firstOrCreate(
            ['email' => 'admin@educonsult.com'],
            [
                'name' => 'Super Admin',
                'phone' => '9800000000',
                'image' => null,
                'password' => Hash::make('Admin@123'),
                'role' => 'Super Admin',  // <-- update role column
            ]
        );
        $superAdmin->assignRole('Super Admin'); // Spatie role

        // -----------------------------
        // ADMIN
        // -----------------------------
        $admin = User::firstOrCreate(
            ['email' => 'subadmin@educonsult.com'],
            [
                'name' => 'Admin',
                'phone' => '9811111111',
                'image' => null,
                'password' => Hash::make('Admin@123'),
                'role' => 'Admin',  // <-- update role column
            ]
        );
        $admin->assignRole('Admin'); // Spatie role
    }
}
