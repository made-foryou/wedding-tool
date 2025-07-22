<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GuestTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('guest_types')->insertOrIgnore([
            'uuid' => Str::uuid(),
            'name' => 'Weekender',
            'description' => 'Gasten welke voor heel het weekend zijn uitgenodigd.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('guest_types')->insertOrIgnore([
            'uuid' => Str::uuid(),
            'name' => 'Avond',
            'description' => 'Gasten wie voor het feest op zaterdag zijn uitgenodigd.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
