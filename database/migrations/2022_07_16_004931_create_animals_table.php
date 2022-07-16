<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnimalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('animals', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->string('nombre');
            $table->integer('limit_cant');
            $table->integer('limit_price_usd');
            $table->integer('status');
            $table->timestamps();
        });

        Schema::create('exchanges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('moneda_id')->nullable()->constrained('monedas');
            $table->float('change_usd', 12, 6);
            $table->timestamps();
        });

        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->string('schedule');
            $table->dateTimeTz('interval_start_utc');
            $table->dateTimeTz('interval_end_utc');
            $table->integer('status');
            $table->timestamps();
        });

        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->nullable()->constrained('users');
            $table->string('nombre');
            $table->string('document')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->integer('status');
            $table->timestamps();
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('status');
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
        Schema::dropIfExists(['animals', 'exchanges', 'schedules', 'customers', 'payments']);
    }
}
