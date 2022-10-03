<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLottoPlusConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lotto_plus_configs', function (Blueprint $table) {
            $table->id();
            $table->float('porcent_comision', 12, 6)->default(0.12);
            $table->float('porcent_cash', 12, 6)->default(0.08);
            $table->float('porcent_limit', 12, 6)->default(0.80);
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
        Schema::dropIfExists('lotto_plus_configs');
    }
}
