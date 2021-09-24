<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topicos', function (Blueprint $table) {
            $table->id();
            $table->string('topico', 100);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('monitoria_id')->nullable();
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('topicos_user_id_foreign');
            $table->dropForeign('topicos_monitoria_id_foreign');
        });

        Schema::dropIfExists('topicos');
    }
}
