<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHipismoTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hipodromos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('country');
            $table->string('flag')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
        });

        Schema::create('races', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->dateTime('race_day');
            $table->integer('status')->default(1);
            $table->foreignId('hipodromo_id')->constrained('hipodromos');
            $table->timestamps();
        });

        Schema::create('fixture_races', function (Blueprint $table) {
            $table->id();
            $table->integer('race_number');
            $table->dateTime('start_time');
            $table->integer('status')->default(1);
            $table->foreignId('race_id')->constrained('races');
            $table->foreignId('hipodromo_id')->constrained('hipodromos');
            $table->timestamps();
        });

        Schema::create('fixture_race_horses', function (Blueprint $table) {
            $table->id();
            $table->integer('horse_number');
            $table->string('horse_name');
            $table->string('jockey_name');
            $table->integer('status')->default(1);
            $table->integer('place')->nullable();
            $table->float('win', 5, 3)->nullable();
            $table->foreignId('fixture_race_id')->constrained('fixture_races');
            // $table->foreignId('hipodromo_id')->constrained('hipodromos');
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
        Schema::dropIfExists('fixture_race_horses');
        Schema::dropIfExists('fixture_races');
        Schema::dropIfExists('races');
        Schema::dropIfExists('hipodromos');
    }
}
