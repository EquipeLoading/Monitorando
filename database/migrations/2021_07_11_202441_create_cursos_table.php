<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCursosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();
            $table->enum('nome', ['Informática integrado ao Ensino Médio', 'Mecânica integrado ao Ensino Médio', 'Eletrônica integrado ao Ensino Médio', 'Eletrotécnica integrado ao Ensino Médio']);
            $table->timestamps();
        });

        Schema::create('curso_disciplinas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('curso_id');
            $table->unsignedBigInteger('disciplina_id');
            $table->timestamps();

            //foreign keys
            $table->foreign('curso_id')->references('id')->on('cursos');
            $table->foreign('disciplina_id')->references('id')->on('disciplinas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('curso_disciplina', function (Blueprint $table) {
            $table->dropForeign('disciplinas_disciplina_id_foreign');
            $table->dropForeign('cursos_curso_id_foreign');
        });

        Schema::dropIfExists('curso_disciplinas');

        Schema::dropIfExists('cursos');
    }
}