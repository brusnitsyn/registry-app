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
        Schema::create('registry_patients', function (Blueprint $table) {
            $table->id();
            $table->uuid('id_pac');
            $table->integer('polis_type')->nullable();
            $table->string('polis_number')->nullable();
            $table->string('smo_code')->nullable();
            $table->boolean('is_newborn');
            $table->boolean('is_invalid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registry_patients');
    }
};
