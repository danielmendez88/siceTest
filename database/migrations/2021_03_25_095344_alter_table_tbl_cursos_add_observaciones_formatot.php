<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableTblCursosAddObservacionesFormatot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_cursos', function (Blueprint $table) {
            //
            $table->jsonb('obser_formato')->nullable();
            $table->dropColumn('observaciones_formato_t');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_cursos', function (Blueprint $table) {
            //
        });
    }
}
