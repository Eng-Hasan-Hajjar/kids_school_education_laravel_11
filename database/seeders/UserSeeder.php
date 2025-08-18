<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the migrations.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Create 10 users
        for ($i = 0; $i < 10; $i++) {
            User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'email_verified_at' => $faker->dateTimeThisYear,
                'password' => Hash::make('password123'), // Default password
                'visit_count' => $faker->numberBetween(0, 100),
                'profile_image' => $faker->optional(0.5)->imageUrl(200, 200, 'people'),
                'payment_receipt' => $faker->optional(0.3)->imageUrl(300, 400, 'business'),
            ]);
        }
    }
}