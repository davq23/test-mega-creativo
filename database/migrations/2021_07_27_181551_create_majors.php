<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMajors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('majors', function (Blueprint $table) {
            // Unsigned BIG INT Autoincrement
            $table->bigIncrements('id')->unsigned()->comment('Identificador único de la carrera');

            // Nombre de la carrera
            $table->string('name', 70)->unique()->comment('Nombre único de la carrera');


            // Descripción de la carrera
            $table->string('description', 255)->nullable()->comment('Descripción de la carrera');

            // Estatus de la carrera (true: activa, false: inactiva)
            $table->boolean('status')->default(true)->comment('Estatus de la carrera (1: activa, 0: inactiva)');

            // Timestamps
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
        Schema::dropIfExists('courses');
    }
}
