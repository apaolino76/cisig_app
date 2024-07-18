<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDataVencimentoToPagamentos4iesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('pagamentos4ies', function (Blueprint $table) {            
            $table->date('data_vencimento')->after('fourIes_id');
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
            $table->dropColumn('data_vencimento');
        });
    }
}
