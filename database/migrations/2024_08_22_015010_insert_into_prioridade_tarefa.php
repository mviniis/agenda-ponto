<?php

use App\Models\Packages\App\Tarefa\Actions\PrioridadeTarefaAction;
use \Illuminate\Database\Migrations\Migration;
use \Mviniis\ConnectionDatabase\SQL\Parts\{SQLValues, SQLValuesGroup};

return new class extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!defined('PATH_ENV_APP')) define('PATH_ENV_APP', __DIR__ . "/../../.env");

		(new PrioridadeTarefaAction)->insert(
			ignore: true,
			values: new SQLValues([
				new SQLValuesGroup([1, 'alta']),
				new SQLValuesGroup([2, 'media']),
				new SQLValuesGroup([3, 'baixa'])
			])
		)->rowCount();
	}
};
