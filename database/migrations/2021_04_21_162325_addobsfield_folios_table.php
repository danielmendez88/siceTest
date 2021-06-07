<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

<<<<<<< HEAD:database/migrations/2020_11_02_171018_create_r911_s_table.php
class CreateR911STable extends Migration
=======
class AddobsfieldFoliosTable extends Migration
>>>>>>> 220835857aeaba9a2e45230e981f02ef32a81606:database/migrations/2021_04_21_162325_addobsfield_folios_table.php
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
<<<<<<< HEAD:database/migrations/2020_11_02_171018_create_r911_s_table.php
        Schema::create('r911_s', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
=======
        Schema::table('folios', function (Blueprint $table) {
            $table->string('observacion_cancelacion')->nullable();
>>>>>>> 220835857aeaba9a2e45230e981f02ef32a81606:database/migrations/2021_04_21_162325_addobsfield_folios_table.php
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
<<<<<<< HEAD:database/migrations/2020_11_02_171018_create_r911_s_table.php
        Schema::dropIfExists('r911_s');
=======
        Schema::table('folios', function (Blueprint $table) {
            //
        });
>>>>>>> 220835857aeaba9a2e45230e981f02ef32a81606:database/migrations/2021_04_21_162325_addobsfield_folios_table.php
    }
}
