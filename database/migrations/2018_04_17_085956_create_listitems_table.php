<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListitemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listitems', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('shoplist_id')->unsigned();
            $table->foreign('shoplist_id')->references('id')->on('shoplists')->onDelete('cascade');
            $table->string('name');
            $table->float('quantity')->default(0.0);
            $table->string('measure')->nullable();
            $table->float('weight_in_gms')->default(0.0);
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('listitems');
    }
}
