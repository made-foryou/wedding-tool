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
        Schema::create('events', function (Blueprint $table) {
            $table->id();

            $table->uuid()
                ->unique();

            $table->foreignId('guest_type_id')
                ->references('id')
                ->on('guest_types')
                ->cascadeOnDelete();

            $table->string('name');
            $table->string('location');
            $table->date('date');
            $table->string('start');

            $table->timestamps();
            $table->softDeletes();
        });
    }
};
