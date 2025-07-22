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
        Schema::create('guest_question_answers', function (Blueprint $table) {
            $table->foreignId('guest_id')
                ->references('id')
                ->on('guests')
                ->cascadeOnDelete();

            $table->foreignId('question_id')
                ->references('id')
                ->on('questions')
                ->cascadeOnDelete();

            $table->text('answer')
                ->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }
};
