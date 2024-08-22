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
        Schema::table('tarefa_historico', function (Blueprint $table) {
            $table->dropColumn('campo_modificacao');
            $table->longText('valor_antes')->nullable()->change();
            $table->longText('valor_depois')->nullable()->change();
        });
    }
};
