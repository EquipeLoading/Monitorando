<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlunosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alunos', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['Monitor', 'Comum']);
            $table->unsignedBigInteger('turma_id');
            $table->unsignedBigInteger('usuario_id');
            $table->timestamps();

            //foreign keys
            $table->foreign('turma_id')->references('id')->on('turmas');
            $table->foreign('usuario_id')->references('id')->on('usuarios');
            $table->unique('usuario_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alunos');
    }
}