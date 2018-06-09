<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIngredientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingredients', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('is_a_recipe')->default(false);
            $table->string('name')->nullable();
            $table->string('Ingredient_line');
            $table->float('quantity')->nullable();
            $table->string('measure')->nullable();
            $table->float('weight_in_gms')->nullable();
            $table->boolean('parsed')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ingredients');
    }
}
