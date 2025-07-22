<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            QuestionTypeSeeder::class,
            GuestTypeSeeder::class,
            EventSeeder::class,
            GuestSeeder::class,
        ]);
    }
}
