<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CandidateUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Candidate User',
            'email' => 'candidate@example.com',
            'password' => Hash::make('password'), // simple demo password
            'role' => 'candidate',
        ]);
    }
}
