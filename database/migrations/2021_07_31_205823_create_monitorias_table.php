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
            $table->string('data_horario');
            $table->integer('num_inscritos');
            $table->string('descricao');
            $table->string('disciplina');
            $table->string('monitor');
            $table->string('local');
            $table->timestamps();
        });

        Schema::create('monitoria_usuarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('monitoria_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            //foreign keys
            $table->foreign('monitoria_id')->references('id')->on('monitorias');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('monitoria_usuarios', function (Blueprint $table) {
            $table->dropForeign('monitoria_usuarios_user_id_foreign');
            $table->dropForeign('monitoria_usuarios_monitoria_id_foreign');
        });

        Schema::dropIfExists('monitoria_usuarios');

        Schema::dropIfExists('monitorias');
    }
}
