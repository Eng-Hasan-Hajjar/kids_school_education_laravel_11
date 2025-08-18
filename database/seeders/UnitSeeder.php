<?php

namespace Database\Seeders;

use App\Models\Section;
use App\Models\Unit;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UnitSeeder extends Seeder
{
    /**
     * Run the migrations.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $sections = Section::all();

        foreach ($sections as $section) {
            // Create 2-4 units per section
            $unitCount = $faker->numberBetween(2, 4);
            for ($i = 0; $i < $unitCount; $i++) {
                Unit::create([
                    'section_id' => $section->id,
                    'Unit_Title' => $section->Section_Title . ' Unit ' . ($i + 1),
                    'Unit_Description' => $faker->sentence,
                ]);
            }
        }
    }
}