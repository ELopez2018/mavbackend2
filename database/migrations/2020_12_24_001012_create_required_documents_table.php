<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequiredDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('required_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("request_service_id");
            $table->unsignedBigInteger("documents_type_id");
            $table->unsignedBigInteger("request_by_id");
            $table->dateTime("fechaRequerimiento")->nullable();
            $table->dateTime("fechaSubido")->nullable();
            $table->string("urlArchivo",2000)->nullable();
            $table->boolean("obligatorio")->nullable();
            $table->timestamps();

             $table->foreign('request_service_id')->references('id')->on('request_services')->onDelete('cascade')->onUpdate('cascade');
              $table->foreign('documents_type_id')->references('id')->on('documents_types')->onDelete('cascade')->onUpdate('cascade');
               $table->foreign('request_by_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('required_documents');
    }
}
