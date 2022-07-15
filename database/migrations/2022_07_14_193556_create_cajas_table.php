<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCajasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cajas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->foreignId('close_user_id')->nullable()->constrained('users');
            $table->dateTimeTz("fecha_apertura");
            $table->dateTimeTz("fecha_cierre")->nullable();
            $table->json("balance_inicial")->nullable();
            $table->json("balance_final")->nullable();
            $table->json("entrada")->nullable();
            $table->integer("status");
            $table->integer("referencia")->nullable();
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
        Schema::dropIfExists('cajas');
    }
}
