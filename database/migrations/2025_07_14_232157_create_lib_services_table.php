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
        Schema::create('lib_services', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->text('name');
            $table->integer('usl_ok')->nullable();
            $table->string('vidpom')->nullable();
            $table->integer('for_pom')->nullable();
            $table->string('profil')->nullable();
            $table->integer('profil_k')->nullable();
            $table->string('p_cel')->nullable();
            $table->string('idsp')->nullable();
            $table->string('cod_nom')->nullable();
            $table->boolean('is_det')->default(false);
            $table->date('begin_at')->nullable();
            $table->date('end_at')->nullable();
            $table->foreignIdFor(\App\Models\LibService::class, 'parent_service_id')->nullable()
                ->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lib_services');
    }
};
