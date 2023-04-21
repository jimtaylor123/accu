<?php

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
        User::factory()->create([
            'name' => "Jim Taylor",
            'email' => "jim@jimtaylor.co.uk",
            'password' => Hash::make('Password123')
        ]);

        User::factory()->count(10)->create();
    }
}