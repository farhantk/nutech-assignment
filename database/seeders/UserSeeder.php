<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Farhan Tirta Kesumah',
            'email' => 'tirta.farhn@gmail.com',
            'role' => 'Web Programmer',
            'avatar' => 'photo/profile.png',
            'password' => '$2y$12$KICJDZE2FP988UQ49v4W/e28hhxKktuPSS1wYi7YCwiff7N0XzUZm',
        ]);
    }
}
