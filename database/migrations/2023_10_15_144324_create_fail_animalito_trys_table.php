<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFailAnimalitoTrysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fail_animalito_trys', function (Blueprint $table) {
            $table->id();
            $table->foreignId('animal_id')->constrained('animals');
            $table->foreignId('sorteo_type_id')->constrained('sorteos_types');
            $table->foreignId('moneda_id')->constrained('monedas');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('horario_id')->constrained('schedules');
            $table->float('total', 12, 6);
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
        Schema::dropIfExists('fail_animalito_trys');
    }
}
