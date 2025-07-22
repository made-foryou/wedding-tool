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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();

            $table->uuid()
                ->unique();

            $table->foreignId('question_type_id')
                ->references('id')
                ->on('question_types')
                ->cascadeOnDelete();

            $table->foreignId('guest_type_id')
                ->nullable()
                ->references('id')
                ->on('guest_types')
                ->nullOnDelete();

            $table->foreignId('event_id')
                ->nullable()
                ->references('id')
                ->on('events')
                ->nullOnDelete();

            $table->string('label');

            $table->text('description')
                ->nullable();

            $table->json('data');

            $table->integer('index')
                ->default(1);

            $table->boolean('is_hidden')
                ->default(false);

            $table->timestamps();
            $table->softDeletes();
        });
    }
};
