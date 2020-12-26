<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTutorialsDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutorials_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tutorial_id')->unsigned()->nullable()->default(null);
            $table->foreign('tutorial_id')->references('id')->on('tutorials')->onDelete('cascade')->onUpdate('cascade');

            $table->bigInteger('video_id')->unsigned()->nullable()->default(null);
            $table->foreign('video_id')->references('id')->on('videos')->onDelete('cascade')->onUpdate('cascade');

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
        Schema::dropIfExists('tutorials_details');
    }
}
