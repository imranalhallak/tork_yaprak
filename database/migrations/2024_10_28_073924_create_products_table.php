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
            $table->foreignId('category_id')
                  ->constrained('categories') // Ensures the foreign key references the 'categories' table
                  ->cascadeOnDelete(); // Cascade on delete to remove associated products when the category is deleted

            $table->integer('position')->nullable(); // Position, can be null

            $table->string('code'); // Product code
            $table->json('images')->nullable(); // Storing images as JSON for flexibility

            // Unique composite index for category_id and code
            $table->unique(['category_id', 'code']);

            $table->timestamps(); // created_at and updated_at timestamps
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
