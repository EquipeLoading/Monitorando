<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonitoriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monitorias', function (Blueprint $table) {
            $table->id();
            $table->string('conteudo');
            $table->string('data');
            $table->string('hora_inicio');
            $table->string('hora_fim');
            $table->string('codigo');
            $table->integer('num_inscritos');
            $table->string('descricao');
            $table->string('disciplina');
            $table->string('monitor');
            $table->string('local');
            $table->timestamps();
        });

        Schema::create('monitoria_user', function(Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('monitoria_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('monitoria_id')->references('id')->on('monitorias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('monitorias');
    }
}
