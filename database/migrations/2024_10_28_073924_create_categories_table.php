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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();

         $table->string('arabic_name')->nullable();
         $table->string('turkish_name')->nullable();
         $table->string('english_name')->nullable();
         $table->integer('position')->nullable();  // Add 'position' column after 'name', adjust as needed

         $table->string('image')->nullable();

         $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
