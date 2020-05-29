<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyAndRemoveColumnTblInscripcionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_inscripcion', function (Blueprint $table) {
            // modificar tabla
            $table->dropColumn('hini2');
            $table->dropColumn('hfin2');
            $table->string('status', 30)->nullable();
            $table->string('motivo', 30)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_inscripcion', function (Blueprint $table) {
            //
        });
    }
}
