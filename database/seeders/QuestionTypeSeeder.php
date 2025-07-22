<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class QuestionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('question_types')->insert([
            'uuid' => Str::uuid(),
            'name' => 'Open vraag',
            'description' => 'Vragen welke een invul veld krijgen en waar de bezoeker zelf een antwoord in kan vullen.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('question_types')->insert([
            'uuid' => Str::uuid(),
            'name' => 'Open vraag (groot)',
            'description' => 'Vragen welke een groot invul veld krijgen en waar de bezoeker zelf een antwoord in kan vullen.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('question_types')->insert([
            'uuid' => Str::uuid(),
            'name' => 'Ja of nee',
            'description' => 'Dit is een vraag waarop ze ja of nee (aan of uit) kunnen antwoorden.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('question_types')->insert([
            'uuid' => Str::uuid(),
            'name' => 'Optie selecteren',
            'description' => 'Deze vragen krijgen een select box met daarin opties welke ze kunnen selecteren.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('question_types')->insert([
            'uuid' => Str::uuid(),
            'name' => 'Meerkeuze',
            'description' => 'Deze vragen krijgen meerdere opties en de invuller kan ook meerdere waardes aanvinken.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
