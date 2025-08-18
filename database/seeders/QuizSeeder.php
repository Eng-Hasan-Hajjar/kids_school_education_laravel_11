<?php

namespace Database\Seeders;

use App\Models\Unit;
use App\Models\Quiz;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class QuizSeeder extends Seeder
{
    /**
     * Run the migrations.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $units = Unit::all();

        foreach ($units as $unit) {
            // Create 1-2 quizzes per unit
            $quizCount = $faker->numberBetween(1, 2);
            for ($i = 0; $i < $quizCount; $i++) {
                Quiz::create([
                    'unit_id' => $unit->id,
                    'Quiz_Title' => $unit->Unit_Title . ' Quiz ' . ($i + 1),
                ]);
            }
        }
    }
}