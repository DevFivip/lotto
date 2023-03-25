<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTripletaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('tripletas', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->foreignId('caja_id')->constrained('cajas');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('admin_id')->constrained('users');
            $table->float('total', 12, 6);
            $table->foreignId('moneda_id')->constrained('monedas');
            $table->integer('has_winner')->default(0);
            $table->integer('status')->default(1);
            $table->timestamps();
        });

        Schema::create('tripleta_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tripleta_id')->constrained('tripletas');
            $table->string('animal_1');
            $table->string('animal_2');
            $table->string('animal_3');
            $table->integer('animal_1_has_win')->default(0);
            $table->integer('animal_2_has_win')->default(0);
            $table->integer('animal_3_has_win')->default(0);
            $table->float('total', 12, 6);
            $table->integer('position_last_sorteo');
            $table->integer('sorteo_left');
            $table->foreignId('sorteo_id')->constrained('sorteos_types');
            $table->timestamps();
        });
        
        // crypto otpyrc

        Schema::create('configs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('value');
        });

        DB::select('INSERT INTO configs (`name`,`value`) VALUES ("TRIPLETA_ENABLE","0")');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tripletas');
        Schema::dropIfExists('tripleta_details');
        Schema::dropIfExists('configs');
    }
}
