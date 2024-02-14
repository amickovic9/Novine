<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
{
    $users = [
        [
            'name' => 'Admin Admin',
            'email' => 'admin@test.com',
            'password' => '$2a$12$kjODAm4GIq1KULYPtR5uxuoNxcH66PUtE.qfH4mPvRXebbFOry.SG',
            'role' => 4,
        ],
        [
            'name' => 'Editor Editor',
            'email' => 'editor@test.com',
            'password' => '$2a$12$kjODAm4GIq1KULYPtR5uxuoNxcH66PUtE.qfH4mPvRXebbFOry.SG',
            'role' => 3,
        ],
        [
            'name' => 'Journalist Journalist',
            'email' => 'journalist@test.com',
            'password' => '$2a$12$kjODAm4GIq1KULYPtR5uxuoNxcH66PUtE.qfH4mPvRXebbFOry.SG',
            'role' => 2,
        ],
    ];

    foreach ($users as $user) {
        if (!User::where('email', $user['email'])->first()) {
            User::factory()->create($user);
        }
    }
}
}