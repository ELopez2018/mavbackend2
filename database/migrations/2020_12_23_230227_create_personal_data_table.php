<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal_data', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->nullable()->default(null);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('role_id')->unsigned()->nullable()->default(null);
            $table->foreign('role_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('din', 15);
            $table->string('pnombre', 30)->nullable();
            $table->string('snombre', 30)->nullable();
            $table->string('apellidop', 30)->nullable();
            $table->string('apellidom', 30)->nullable();
            $table->string('celular', 20)->nullable();
            $table->string('telefonos', 100)->nullable();
            $table->string('pais', 50)->nullable();
            $table->string('departamento', 50)->nullable();
            $table->string('ciudad', 50)->nullable();
            $table->string('barrio', 50)->nullable();
            $table->string('direccion', 50)->nullable();
            $table->dateTime('fechanacimiento')->nullable();
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
        Schema::dropIfExists('personal_data');
    }
}
