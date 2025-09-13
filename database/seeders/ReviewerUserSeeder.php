<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ReviewerUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Reviewer User',
            'email' => 'reviewer@example.com',
            'password' => Hash::make('password'), // simple demo password
            'role' => 'reviewer',
        ]);
    }
}
