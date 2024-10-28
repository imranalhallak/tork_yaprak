<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // Primary key: id
            $table->foreignId('category_id') // Foreign key referencing the menu table
                  ->constrained('categories') // Reference the 'menu' table
                  ->cascadeOnDelete(); // Cascade delete when the related menu is deleted
            $table->string('arabic_name');
            $table->integer('position')->nullable();  // Adjust 'after' as per your column order

            $table->string('turkish_name');
            $table->string('english_name');
            $table->text('arabic_description')->nullable();
            $table->text('turkish_description')->nullable();
            $table->text('english_description')->nullable();
            $table->integer('price'); // Storing price as an integer
            $table->string('code')->unique(); // Unique product code
            $table->string('image')->nullable(); // Product image
            $table->unique(['category_id', 'code']);

            $table->timestamps(); // Adds created_at and updated_at

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}