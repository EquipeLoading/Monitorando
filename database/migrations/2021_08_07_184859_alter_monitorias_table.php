<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterMonitoriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('monitorias', function (Blueprint $table) {;
            $table->dropColumn('data_horario');
            $table->string('data');
            $table->string('hora_inicio');
            $table->string('hora_fim');
            $table->string('codigo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('monitorias', function (Blueprint $table) {
            $table->dropColumn('data');
            $table->dropColumn('hora_inicio');
            $table->dropColumn('hora_fim');
            $table->dropColumn('codigo');
            $table->string('data_horario');
        });
    }
}
