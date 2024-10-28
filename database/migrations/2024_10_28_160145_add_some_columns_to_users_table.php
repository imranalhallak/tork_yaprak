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
        Schema::table('products', function (Blueprint $table) {
            $table->string('type_of_spiral')->nullable();
            $table->string('notebook_size')->nullable();
            $table->string('cover_type')->nullable();
            $table->string('paper_weight')->nullable();
            $table->integer('number_of_pages')->nullable();
            $table->string('notebook_ruling')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([

                'type_of_spiral',
                'notebook_size',
                'cover_type',
                'paper_weight',
                'number_of_pages',
                'notebook_ruling',
            ]);
        });
    }
};
