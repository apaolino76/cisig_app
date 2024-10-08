<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNomeToPagamentos4iesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('pagamentos4ies', function (Blueprint $table) {
            $table->string('nome', 85)->after('matricula');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql')->table('pagamentos4ies', function (Blueprint $table) {
            $table->dropColumn('nome');
        });
    }
}
