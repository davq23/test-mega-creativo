<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            // ID del estudiante
            $table->bigIncrements('id')->unsigned()->comment('Identificador único del estudiante');

            // Nombre del estudiante
            $table->string('name', 80)->comment('Nombre del estudiante');

            // Apellidos del estudiante
            $table->string('last_names', 165)->comment('Apellidos del estudiante');

            // Email del estudiante
            $table->string('email', 120)->comment('Email del estudiante');

            // ID de carrera del estudiante
            $table->bigInteger('major_id', false, true)->nullable()
                ->comment('Identificador de la carrera del estudiante');

            // Referencia a la tabla carreras
            $table->foreign('major_id')->references('id')->on('majors')
                ->onUpdate('cascade')->onDelete('set null');

            // Estatus del estudiante (1: activo, 0: inactivo)
            $table->boolean('status')->default(true)
                ->comment('Estatus del estudiante (1: activo, 0: inactivo');

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
        Schema::dropIfExists('students');
    }
}
