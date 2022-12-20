<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AnimalitoScheduleLimitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('animalito_schedule_limits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('animal_id')->constrained('animals');
            $table->foreignId('schedule_id')->constrained('schedules');
            $table->float('limit', 12, 6);
            $table->timestamps();
        });


        Schema::table('sorteos_types', function (Blueprint $table) {
            //
            $table->float('limit_max', 12, 6)->default(100);
            $table->float('limit_reduce', 12, 6)->default(100);
        });
        //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('animalito_schedule_limits');

        Schema::table('sorteos_types', function (Blueprint $table) {
            //
            $table->dropColumn([
                'comision',
                'premio',
                'balance'
            ]);
        });
    }
}
