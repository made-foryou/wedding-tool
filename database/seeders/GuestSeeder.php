<?php

namespace Database\Seeders;

use App\Domains\Guests\Imports\GuestsImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class GuestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Excel::import(new GuestsImport, storage_path('app/private/gasten-export.xlsx'));
    }
}
