<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Section;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UserSectionSeeder extends Seeder
{
    /**
     * Run the migrations.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $users = User::pluck('id')->toArray();
        $sections = Section::pluck('id')->toArray();

        // Assign each user to 1-3 random sections
        foreach ($users as $userId) {
            $randomSections = $faker->randomElements($sections, $faker->numberBetween(1, 3));
            foreach ($randomSections as $sectionId) {
                \DB::table('user_section')->insert([
                    'user_id' => $userId,
                    'section_id' => $sectionId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}