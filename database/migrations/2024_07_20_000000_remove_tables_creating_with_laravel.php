<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Remove as tabelas que foram criadas pelos pacotes instalados
	 * @return void
	 */
	public function up()
	{
		Schema::dropIfExists('personal_access_tokens');
	}
};
