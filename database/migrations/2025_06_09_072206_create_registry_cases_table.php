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
        Schema::create('registry_cases', function (Blueprint $table) {
            $table->id();
            $table->string('id_case');
            $table->string('treatment_type');
            $table->string('result');
            $table->string('outcome');
            $table->string('total_sum');
            $table->string('diagnosis');
            $table->foreignIdFor(\App\Models\RegistryPatient::class, 'patient_id');
            $table->foreignIdFor(\App\Models\RegistryFile::class, 'registry_file_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registry_cases');
    }
};
