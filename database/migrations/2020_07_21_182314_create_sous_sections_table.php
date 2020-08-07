<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSousSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sous_sections', function (Blueprint $table) {
            $table->string('slug')->primary();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('illustration')->nullable();
            $table->string('id_section');
            $table->foreign('id_section')
                ->references('slug')
                ->on('sections');
                
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
        Schema::dropIfExists('sous_sections');
    }
}
