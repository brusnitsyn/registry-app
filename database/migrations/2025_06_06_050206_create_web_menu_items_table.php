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
        Schema::create('web_menu_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('position');
            $table->string('label');
            $table->string('key');
            $table->string('href')->nullable();
            $table->string('icon')->nullable();
            $table->boolean('has_children')->default(false);
            $table->foreignIdFor(\App\Models\WebMenuItem::class, 'parent_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('web_menu_items');
    }
};
