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
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            //foreign keys
            $table->foreign('turma_id')->references('id')->on('turmas');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unique('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('alunos', function (Blueprint $table) {
            $table->dropForeign('alunos_user_id_foreign');
            $table->dropForeign('alunos_turma_id_foreign');
        });

        Schema::dropIfExists('alunos');
    }
}