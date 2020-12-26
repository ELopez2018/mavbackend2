<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIssuedDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issued_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_emisor_id");
            $table->unsignedBigInteger("user_destino_id");
            $table->string("descripcion",2000)->nullable();
            $table->string("urlDocumento",1000)->nullable();
            $table->dateTime("fechaEnviado")->nullable();
            $table->dateTime("fechaDescargado")->nullable();
            $table->dateTime("fechaMensajeLeido")->nullable();
            $table->timestamps();
             $table->foreign('user_emisor_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
             $table->foreign('user_destino_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('issued_documents');
    }
}
