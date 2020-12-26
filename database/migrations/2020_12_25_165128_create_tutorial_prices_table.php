<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTutorialPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutorial_prices', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tutorial_id')->unsigned()->nullable()->default(null);
            $table->foreign('tutorial_id')->references('id')->on('tutorials')->onDelete('cascade')->onUpdate('cascade');
            $table->dateTime('fecha');
            $table->dateTime('caducidad');
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
        Schema::dropIfExists('tutorial_prices');
    }
}
