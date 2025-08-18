<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class SectionSeeder extends Seeder
{
    /**
     * Run the migrations.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $sections = [
            ['title' => 'Mathematics', 'description' => 'Learn basic math skills like counting, addition, and subtraction.'],
            ['title' => 'English', 'description' => 'Improve reading, writing, and speaking in English.'],
            ['title' => 'Science', 'description' => 'Explore the wonders of science through fun experiments.'],
            ['title' => 'Art', 'description' => 'Unleash creativity with drawing and crafts.'],
            ['title' => 'Music', 'description' => 'Discover musical instruments and rhythms.'],
        ];

        foreach ($sections as $section) {
            Section::create([
                'Section_Title' => $section['title'],
                'Section_Description' => $section['description'],
            ]);
        }

        // Additional random sections
        for ($i = 0; $i < 5; $i++) {
            Section::create([
                'Section_Title' => $faker->words(2, true),
                'Section_Description' => $faker->sentence,
            ]);
        }
    }
}