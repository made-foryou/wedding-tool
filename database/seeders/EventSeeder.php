<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $weekender = DB::table('guest_types')
            ->select('id')
            ->where('name', 'Weekender')
            ->firstOrFail()
            ->id;

        $avond = DB::table('guest_types')
            ->select('id')
            ->where('name', 'Avond')
            ->firstOrFail()
            ->id;

        DB::table('events')->insertOrIgnore([
            'uuid' => Str::uuid(),
            'guest_type_id' => $avond,
            'name' => 'Het feest',
            'location' => 'Landgoed Twistvliet',
            'date' => '2025-10-25',
            'start' => '20:00',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('events')->insertOrIgnore([
            'uuid' => Str::uuid(),
            'guest_type_id' => $weekender,
            'name' => 'Pre-wedding borrel',
            'location' => 'Landgoed Twistvliet',
            'date' => '2025-10-24',
            'start' => '20:00',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('events')->insertOrIgnore([
            'uuid' => Str::uuid(),
            'guest_type_id' => $weekender,
            'name' => 'The day morning brunch',
            'location' => 'Landgoed Twistvliet',
            'date' => '2025-10-25',
            'start' => '11:00',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('events')->insertOrIgnore([
            'uuid' => Str::uuid(),
            'guest_type_id' => $weekender,
            'name' => 'Ceremonie',
            'location' => 'Landgoed Twistvliet',
            'date' => '2025-10-25',
            'start' => '13:00',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('events')->insertOrIgnore([
            'uuid' => Str::uuid(),
            'guest_type_id' => $weekender,
            'name' => 'After yes borrel',
            'location' => 'Landgoed Twistvliet',
            'date' => '2025-10-25',
            'start' => '15:00',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('events')->insertOrIgnore([
            'uuid' => Str::uuid(),
            'guest_type_id' => $weekender,
            'name' => 'Dinner',
            'location' => 'Landgoed Twistvliet',
            'date' => '2025-10-25',
            'start' => '18:00',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('events')->insertOrIgnore([
            'uuid' => Str::uuid(),
            'guest_type_id' => $weekender,
            'name' => 'Het feest',
            'location' => 'Landgoed Twistvliet',
            'date' => '2025-10-25',
            'start' => '20:00',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('events')->insertOrIgnore([
            'uuid' => Str::uuid(),
            'guest_type_id' => $weekender,
            'name' => 'Day after breakfast',
            'location' => 'Landgoed Twistvliet',
            'date' => '2025-10-26',
            'start' => '11:00',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
