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
		Schema::create('tarefa_historico', function (Blueprint $table) {
			// CAMPOS DA TABELA
			$table->id();
			$table->enum('tipo_modificacao', ['criacao','edicao','remocao'])->default('criacao')->index('tipo_modificacao');
			$table->string('campo_modificacao', 100);
			$table->longText('valor_antes');
			$table->longText('valor_depois');
			$table->unsignedBigInteger('id_tarefa');
			$table->unsignedBigInteger('id_usuario');
			$table->timestamp('data_hora_alteracao')->useCurrent()->index('data_hora_alteracao');

			// DEFINIÇÃO DAS CHAVES ESTRANGEIRAS
			$table->foreign('id_tarefa')->references('id')->on('tarefa');
			$table->foreign('id_usuario')->references('id')->on('usuario');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('tarefa_historico');
	}
};
