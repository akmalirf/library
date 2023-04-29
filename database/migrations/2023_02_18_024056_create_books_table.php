<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->integer('isbn');
            $table->string('title', 64);
            $table->integer('year');
            $table->integer('qty');
            $table->integer('price');
            $table->timestamps();

            $table->foreignId('publisher_id')->constrained('publishers')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('author_id')->constrained('authors')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('catalog_id')->constrained('catalogs')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
};
