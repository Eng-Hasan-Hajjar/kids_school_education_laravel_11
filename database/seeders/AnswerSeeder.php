<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\Answer;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class AnswerSeeder extends Seeder
{
    /**
     * Run the migrations.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $questions = Question::all();

        foreach ($questions as $question) {
            // Create 4 answers per question, with exactly one correct answer
            $correctAnswerIndex = $faker->numberBetween(0, 3);
            for ($i = 0; $i < 4; $i++) {
                Answer::create([
                    'question_id' => $question->id,
                    'Answer_Text' => $faker->word,
                    'Iscorrect' => $i === $correctAnswerIndex ? true : false,
                    'sound' => $faker->optional(0.5)->filePath(),
                    'image' => $faker->optional(0.5)->imageUrl(640, 480, 'education'),
                ]);
            }
        }
    }
}