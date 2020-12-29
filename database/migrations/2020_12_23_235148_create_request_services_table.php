<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_services', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->nullable()->default(null);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

            $table->bigInteger("request_type_id")->unsigned()->nullable()->default(null);
            $table->foreign('request_type_id')->references('id')->on('request_types')->onDelete('cascade')->onUpdate('cascade');

            $table->bigInteger("service_type_id")->unsigned()->nullable()->default(null);
            $table->foreign('service_type_id')->references('id')->on('services_types')->onDelete('cascade')->onUpdate('cascade');

            $table->bigInteger("request_state_id")->unsigned()->nullable()->default(0);
            $table->foreign('request_state_id')->references('id')->on('request_states')->onDelete('cascade')->onUpdate('cascade');

            $table->string("telefono",50);
            $table->text("mensaje")->nullable();
            $table->boolean("finalizada");
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
        Schema::dropIfExists('request_services');
    }
}
