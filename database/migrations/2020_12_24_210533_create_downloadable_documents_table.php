<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDownloadableDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('downloadable_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("access_level_id");
            $table->text("descripcion")->nullable();
            $table->text("urlDocumento")->nullable();
            $table->timestamps();
            $table->foreign('access_level_id')->references('id')->on('access_levels')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('downloadable_documents');
    }
}
