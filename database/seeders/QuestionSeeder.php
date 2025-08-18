<?php

namespace Database\Seeders;

use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class QuestionSeeder extends Seeder
{
    /**
     * Run the migrations.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $quizzes = Quiz::all();

        foreach ($quizzes as $quiz) {
            // Create 3-5 questions per quiz
            $questionCount = $faker->numberBetween(3, 5);
            for ($i = 0; $i < $questionCount; $i++) {
                Question::create([
                    'quiz_id' => $quiz->id,
                    'Question_Text' => $faker->sentence . '?',
                    'sound' => $faker->optional(0.5)->filePath(),
                    'image' => $faker->optional(0.5)->imageUrl(640, 480, 'education'),
                ]);
            }
        }
    }
}