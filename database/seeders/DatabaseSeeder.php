<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
          
            RolesTableSeeder::class,
            UserSeeder::class,
            SectionSeeder::class,
            UserSectionSeeder::class,
            UnitSeeder::class,
            LessonSeeder::class,
            ContentSeeder::class,
            QuizSeeder::class,
            QuestionSeeder::class,
            AnswerSeeder::class,
      
        ]);

    }
}
