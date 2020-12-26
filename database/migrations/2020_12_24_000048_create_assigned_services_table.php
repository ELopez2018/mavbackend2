<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignedServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assigned_services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("assigned_to_id");
            $table->unsignedBigInteger("request_service_id");
            $table->dateTime("fechaAsignacion")->nullable();
            $table->text("observaciones")->nullable();
            $table->timestamps();

             $table->foreign('assigned_to_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
              $table->foreign('request_service_id')->references('id')->on('request_services')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assigned_services');
    }
}
