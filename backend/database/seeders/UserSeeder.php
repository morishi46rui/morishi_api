<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->createMany([
            [
                'name' => 'rui',
                'email' => 'rui@example.com',
                'password' => Hash::make('P@ssw0rd'),
            ],
            [
                'name' => 'admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('P@ssw0rd'),
            ],
        ]);
    }
}
