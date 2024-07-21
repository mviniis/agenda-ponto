<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tarefa_usuario', function (Blueprint $table) {
			// CAMPOS DA TABELA
			$table->unsignedBigInteger('id_tarefa');
			$table->unsignedBigInteger('id_usuario');
			$table->unsignedInteger('id_perfil_tarefa');
			$table->primary(['id_tarefa', 'id_usuario'], 'id_tarefa_usuario');

			// DEFINIÇÃO DAS CHAVES ESTRANGEIRAS
			$table->foreign('id_tarefa')->references('id')->on('tarefa');
			$table->foreign('id_usuario')->references('id')->on('usuario');
			$table->foreign('id_perfil_tarefa')->references('id')->on('perfil_tarefa');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('tarefa_usuario');
	}
};
