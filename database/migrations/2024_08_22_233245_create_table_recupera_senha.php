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
	public function up() {
		Schema::create('recuperar_senha', function (Blueprint $table) {
			// CAMPOS DA TABELA
			$table->bigIncrements('id');
			$table->unsignedBigInteger('id_pessoa');
			$table->string('codigo', 8)->nullable();
			$table->timestamp('data_hora_expiracao')->useCurrent()->index('data_hora_expiracao');

			// DEFINIÇÃO DAS CHAVES ESTRANGEIRAS
			$table->foreign('id_pessoa')->references('id')->on('pessoa');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('prioridade_tarefa');
	}
};
