<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $user = User::where('email', 'test@test.com')->first();

        if (!$user) {
            User::factory()->create([
                'name' => 'Test Name1',
                'email' => 'test@test.com',
                'password' => '$2a$12$kjODAm4GIq1KULYPtR5uxuoNxcH66PUtE.qfH4mPvRXebbFOry.SG', 
                'role' => 4,
            ]);
        }
    }
    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}