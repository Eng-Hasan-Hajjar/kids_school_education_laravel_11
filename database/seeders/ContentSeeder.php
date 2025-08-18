<?php

namespace Database\Seeders;

use App\Models\Lesson;
use App\Models\Content;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ContentSeeder extends Seeder
{
    /**
     * Run the migrations.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $lessons = Lesson::all();

        foreach ($lessons as $lesson) {
            // Create 1-3 content items per lesson
            $contentCount = $faker->numberBetween(1, 3);
            for ($i = 0; $i < $contentCount; $i++) {
                Content::create([
                    'lesson_id' => $lesson->id,
                    'Text' => implode(' ', $faker->sentences($faker->numberBetween(1, 3))), // نص قصير من 1-3 جمل
                    'sound' => $faker->optional(0.5)->filePath(),
                    'image' => $faker->optional(0.5)->imageUrl(640, 480, 'education'),
                ]);
            }
        }
    }
}
