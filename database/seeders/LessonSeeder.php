<?php

namespace Database\Seeders;

use App\Models\Unit;
use App\Models\Lesson;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class LessonSeeder extends Seeder
{
    /**
     * Run the migrations.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $units = Unit::all();

        foreach ($units as $unit) {
            // Create 2-5 lessons per unit
            $lessonCount = $faker->numberBetween(2, 5);
            for ($i = 0; $i < $lessonCount; $i++) {
                Lesson::create([
                    'unit_id' => $unit->id,
                    'Lesson_Title' => $unit->Unit_Title . ' Lesson ' . ($i + 1),
                ]);
            }
        }
    }
}