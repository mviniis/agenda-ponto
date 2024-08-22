<?php

use \Illuminate\Database\Migrations\Migration;
use \App\Models\Packages\App\PerfilTarefa\Actions\PerfilTarefaAction;
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

		(new PerfilTarefaAction)->insert(
			ignore: true,
			values: new SQLValues([
				new SQLValuesGroup([1, 'Admin', 's', 's', 's']),
				new SQLValuesGroup([2, 'Editor', 's', 's', 'n']),
				new SQLValuesGroup([3, 'Observador', 's', 'n', 'n'])
			])
		)->rowCount();
	}
};
