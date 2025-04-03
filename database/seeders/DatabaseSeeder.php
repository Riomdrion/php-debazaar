<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Bedrijf;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Define users and their roles
        $userRolesAndPasswords = [
            ['name' => 'Ron', 'role' => 'gebruiker', 'password' => 'password1'],
            ['name' => 'Bas', 'role' => 'zakelijk', 'password' => 'password2'],
            ['name' => 'Max', 'role' => 'particulier', 'password' => 'password3'],
            ['name' => 'Rodin', 'role' => 'zakelijk', 'password' => 'password4'],
            ['name' => 'Admin', 'role' => 'admin', 'password' => 'adminpassword'],
        ];

        $users = [];
        foreach ($userRolesAndPasswords as $userDetails) {
            $users[] = User::factory()->create([
                'name' => $userDetails['name'],
                'email' => strtolower($userDetails['name']) . '@example.com',
                'role' => $userDetails['role'],
                'password' => Hash::make($userDetails['password']),
            ]);
        }

        // Create two specific bedrijven for 'zakelijk' users
        $zakelijkUsers = array_values(array_filter($users, fn($user) => $user->role === 'zakelijk')); // Reindex the array

        $bedrijfDetails = [
            ['naam' => 'Jumbo', 'custom_url' => 'jumbo'],
            ['naam' => 'MediaMarkt', 'custom_url' => 'mediamarkt']
        ];

        foreach ($bedrijfDetails as $key => $details) {
            if (isset($zakelijkUsers[$key])) {
                Bedrijf::factory()->create([
                    'naam' => $details['naam'],
                    'custom_url' => $details['custom_url'],
                    'user_id' => $zakelijkUsers[$key]->id,
                ]);
            }
        }
    }
}
