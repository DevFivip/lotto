<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('registers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->foreignId('caja_id')->constrained('cajas');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('admin_id')->constrained('users');
            $table->float('total', 12, 6);
            $table->foreignId('moneda_id')->constrained('monedas');
            $table->integer('has_winner')->default(0);
            $table->integer('status')->default(1);
            $table->timestamps();
        });

        Schema::create('register_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('register_id')->constrained('registers');
            $table->foreignId('animal_id')->constrained('animals');
            $table->string('schedule');
            $table->foreignId('schedule_id')->constrained('schedules');
            $table->foreignId('admin_id')->constrained('users');
            $table->integer('winner')->default(0);
            $table->float('monto', 12, 6);
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
        Schema::dropIfExists('registers', 'register_details');
    }
}
