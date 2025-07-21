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
        Schema::create('guests', function (Blueprint $table) {
            $table->id();

            $table->uuid()
                ->unique();

            // Relation with the guest type
            $table
                ->foreignId('guest_type_id')
                ->references('id')
                ->on('guest_types')
                ->restrictOnDelete();

            // Name
            $table->string('first_name');
            $table->string('last_name')->nullable();

            // Contact information
            $table->string('email')->unique();
            $table->string('phone_number')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guests');
    }
};
