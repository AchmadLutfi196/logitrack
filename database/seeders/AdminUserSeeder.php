<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@logitrack.id'],
            [
                'name' => 'Admin Logitrack',
                'role' => 'admin',
                'phone' => '081234567890',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
            ]
        );
    }
}
