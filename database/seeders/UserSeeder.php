<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Roles (if not exists)
        // $adminRole = Role::firstOrCreate(['name' => 'admin']);
        // $userRole  = Role::firstOrCreate(['name' => 'user']);

        // Admin User
        $admin = User::create([
            'full_name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'phone' => '01700000000',
            'status' => 1,
            'is_volunteer' => 0,
            'email_verified_at' => now(),
        ]);

      //  $admin->assignRole($adminRole);

        // Normal Users
        $users = [
            [
                'full_name' => 'Rahim Uddin',
                'email' => 'rahim@example.com',
                'phone' => '01811111111',
                'is_volunteer' => 1,
            ],
            [
                'full_name' => 'Karim Hasan',
                'email' => 'karim@example.com',
                'phone' => '01922222222',
                'is_volunteer' => 0,
            ],
            [
                'full_name' => 'Ayesha Akter',
                'email' => 'ayesha@example.com',
                'phone' => '01633333333',
                'is_volunteer' => 1,
            ],
        ];

        foreach ($users as $data) {
            $user = User::create([
                'full_name' => $data['full_name'],
                'email' => $data['email'],
                'password' => Hash::make('password'),
                'phone' => $data['phone'],
                'status' => 1,
                'is_volunteer' => $data['is_volunteer'],
                'email_verified_at' => now(),
            ]);

       //     $user->assignRole($userRole);
        }
    }
}
