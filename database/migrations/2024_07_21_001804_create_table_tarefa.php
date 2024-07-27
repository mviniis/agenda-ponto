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
		Schema::create('tarefa', function (Blueprint $table) {
			// CAMPOS DA TABELA
			$table->bigIncrements('id');
			$table->string('nome', 100)->index('nome');
			$table->text('descricao');
			$table->unsignedInteger('id_prioridade');
			$table->enum('concluido', ['s', 'n'])->default('n')->index('concluido');
			
			// DEFINIÇÃO DAS CHAVES ESTRANGEIRAS
			$table->foreign('id_prioridade')->references('id')->on('prioridade_tabela');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('tarefa');
	}
};
