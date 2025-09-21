<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('guests', function (Blueprint $table) {
            $table->boolean('present')
                ->default(false)
                ->after('has_registered');
        });

        DB::table('guests')
            ->join('event_guest', 'guests.id', '=', 'event_guest.guest_id')
            ->where('has_registered', true)
            ->update(['present' => true]);
    }
};
