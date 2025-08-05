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
        Schema::create('lib_departments', function (Blueprint $table) {
            $table->id();
            $table->string('podr');
            $table->string('name');
            $table->foreignIdFor(\App\Models\LibDepartmentType::class, 'department_type_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lib_departments');
    }
};
