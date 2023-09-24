<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddColumnsToHipismoTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hipismo_remate_heads', function (Blueprint $table) {
            $table->id();
            $table->float('total', 12, 6);
            $table->float('pagado', 12, 6);
            $table->foreignId('admin_id')->constrained('users');
            $table->foreignId('user_id')->constrained('users');
            $table->integer('status')->default(1);
            $table->integer('fixture_race_id');
            $table->timestamps();
        });

        Schema::table('hipismo_remates', function (Blueprint $table) {
            $table->integer("pay_porcent")->nullable();
            $table->integer("status_pago")->nullable();
            $table->integer("status_pagado")->nullable();
            $table->integer("hipismo_remate_head_id");
            // $table->foreignId('hipismo_remate_head_id')->constrained('hipismo_remate_heads');
        });


        Schema::table('fixture_race_horses', function (Blueprint $table) {
            $table->integer("remate_winner")->nullable();
        });

        Schema::create('hipismo_bancas', function (Blueprint $table) {
            $table->id();
            $table->float('total', 12, 6);
            $table->foreignId('admin_id')->constrained('users');
            $table->foreignId('user_id')->constrained('users');
            $table->integer('status')->default(1);
            $table->timestamps();
        });

        Schema::create('hipismo_banca_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hipismo_banca_id')->constrained('hipismo_bancas');
            $table->integer('logro');
            $table->float('total', 12, 6);
            $table->foreignId('horse_id')->constrained('fixture_race_horses');
            $table->foreignId('fixture_race_id')->constrained('fixture_races');
            $table->foreignId('admin_id')->constrained('users');
            $table->foreignId('user_id')->constrained('users');
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('hipismo_remate_heads');

        Schema::table('hipismo_bancas', function (Blueprint $table) {
            $table->dropForeign('hipismo_bancas_user_id_foreign');
            $table->dropForeign('hipismo_bancas_admin_id_foreign');
        });

        Schema::table('hipismo_banca_details', function (Blueprint $table) {
            $table->dropForeign('hipismo_banca_details_admin_id_foreign');
            $table->dropForeign('hipismo_banca_details_fixture_race_id_foreign');
            $table->dropForeign('hipismo_banca_details_hipismo_banca_id_foreign');
            $table->dropForeign('hipismo_banca_details_horse_id_foreign');
            $table->dropForeign('hipismo_banca_details_user_id_foreign');
        });

        Schema::table('hipismo_remates', function (Blueprint $table) {
            $table->dropColumn(['pay_porcent']);
            $table->dropColumn(['status_pago']);
            $table->dropColumn(['status_pagado']);
            $table->dropColumn(['hipismo_remate_head_id']);
        });

        Schema::table('fixture_race_horses', function (Blueprint $table) {
            $table->dropColumn(['remate_winner']);
        });


        // Schema::table('hipismo_banca_details', function (Blueprint $table) {
        //     $table->dropForeign('user_id');
        //     $table->dropForeign('admin_id');
        //     $table->dropForeign('horse_id');
        //     $table->dropForeign('fixture_race_id');
        // });

        // DB::select('DROP TABLE IF EXISTS hipismo_banca');
        // DB::select('DROP TABLE IF EXISTS hipismo_banca_details');

        Schema::dropIfExists('hipismo_bancas');
        Schema::dropIfExists('hipismo_banca_details');
    }
}
