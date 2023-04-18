<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTripletaDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tripleta_details', function (Blueprint $table) {
            $table->string("primer_sorteo");
            $table->string("ultimo_sorteo");
            // $table->float("fondo", 8, 6)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tripleta_details', function (Blueprint $table) {
            $table->dropColumn(['primer_sorteo']);
            $table->dropColumn(['ultimo_sorteo']);
        });
    }
}
