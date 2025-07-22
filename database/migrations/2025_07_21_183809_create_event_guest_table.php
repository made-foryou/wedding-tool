<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('event_guest', function (Blueprint $table) {
            $table->foreignId('event_id')
                ->references('id')
                ->on('events')
                ->cascadeOnDelete();

            $table->foreignId('guest_id')
                ->references('id')
                ->on('guests')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }
};
