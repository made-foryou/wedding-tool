<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('question_types')->insert([
            'name' => 'Open vraag',
            'description' => 'Vragen welke een invul veld krijgen en waar de bezoeker zelf een antwoord in kan vullen.',
        ]);

        DB::table('question_types')->insert([
            'name' => 'Open vraag (groot)',
            'description' => 'Vragen welke een groot invul veld krijgen en waar de bezoeker zelf een antwoord in kan vullen.',
        ]);

        DB::table('question_types')->insert([
            'name' => 'Ja of nee',
            'description' => 'Dit is een vraag waarop ze ja of nee (aan of uit) kunnen antwoorden.',
        ]);

        DB::table('question_types')->insert([
            'name' => 'Optie selecteren',
            'description' => 'Deze vragen krijgen een select box met daarin opties welke ze kunnen selecteren.',
        ]);

        DB::table('question_types')->insert([
            'name' => 'Meerkeuze',
            'description' => 'Deze vragen krijgen meerdere opties en de invuller kan ook meerdere waardes aanvinken.',
        ]);
    }
}
