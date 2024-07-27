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
		Schema::create('pessoa_fisica', function (Blueprint $table) {
			// CAMPOS DA TABELA
			$table->bigIncrements('id');
			$table->unsignedBigInteger('id_pessoa');
			$table->string('cpf', 11)->unique('cpf');
			$table->string('nome', 100);
			$table->string('sobrenome', 100)->nullable();

			// DEFINIÇÃO DAS CHAVES ESTRANGEIRAS
			$table->foreign('id_pessoa')->references('id')->on('pessoa');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('pessoa_fisica');
	}
};
