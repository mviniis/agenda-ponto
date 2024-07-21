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
		Schema::create('perfil_tarefa', function (Blueprint $table) {
			$table->increments('id');
			$table->string('nome', 50)->index('nome');
			$table->enum('visualizar', ['s', 'n'])->default('n')->index('visualizar');
			$table->enum('editar', ['s', 'n'])->default('n')->index('editar');
			$table->enum('remover', ['s', 'n'])->default('n')->index('remover');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('perfil_tarefa');
	}
};
