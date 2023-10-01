<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->float("hipodromo_banca_unidad", 12, 2)->nullable();
        });

        Schema::table('hipismo_bancas', function (Blueprint $table) {
            $table->string('code');
            $table->integer('fixture_race_id');
            $table->integer('moneda_id');
            // $table->foreignId('moneda_id')->constrained('monedas');
            $table->integer('apuesta_type');
            $table->text('combinacion');
            $table->float('unidades', 12, 2)->default(1);
        });

        Schema::create('hipismo_banca_resultados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('users');
            // $table->foreignId('fixture_race_id')->constrained('fixture_races');
            $table->integer('fixture_race_id');
            $table->integer('apuesta_type'); // 1 ganador // 2 exacta // 3 trifecta //
            $table->text('combinacion');
            $table->float('win', 12, 3);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['hipodromo_banca_unidad']);
        });

        Schema::table('hipismo_bancas', function (Blueprint $table) {
            $table->dropColumn(['code']);
            $table->dropColumn(['combinacion']);
            $table->dropColumn(['apuesta_type']);
            $table->dropColumn(['unidades']);
            // $table->dropForeign('hipismo_bancas_moneda_id_foreign');
            $table->dropColumn(['moneda_id']);
            // $table->dropForeign('hipismo_bancas_fixture_race_id_foreign');
            $table->dropColumn(['fixture_race_id']);
        });

        Schema::dropIfExists('hipismo_banca_resultados');
    }
}
