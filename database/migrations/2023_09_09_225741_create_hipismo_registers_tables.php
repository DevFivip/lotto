<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHipismoRegistersTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hipismo_remates', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->foreignId('admin_id')->constrained('users');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('fixture_race_id')->constrained('fixture_races');
            $table->foreignId('horse_id')->constrained('fixture_race_horses');
            $table->foreignId('moneda_id')->constrained('monedas');
            $table->float('monto', 12, 6)->nullable();
            $table->string('cliente')->nullable();
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
        Schema::dropIfExists('hipismo_remates');
    }
}
