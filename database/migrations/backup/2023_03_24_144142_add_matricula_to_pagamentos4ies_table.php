<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMatriculaToPagamentos4iesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('pagamentos4ies', function (Blueprint $table) {
            $table->string('matricula', 16)->after('codigo');
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
            $table->dropColumn('matricula');
        });
    }
}
