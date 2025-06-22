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
        Schema::create('registry_services', function (Blueprint $table) {
            $table->id();
            $table->uuid('id_serv');
            $table->string('code');
            $table->date('date_in');
            $table->date('date_out');
            $table->decimal('tariff', 14);
            $table->decimal('sum', 14);
            $table->decimal('count', 5);
            $table->string('department_code')->nullable();
            $table->string('doctor_speciality')->nullable();
            $table->string('doctor_id')->nullable();
            $table->foreignIdFor(\App\Models\RegistryCase::class, 'case_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registry_services');
    }
};
