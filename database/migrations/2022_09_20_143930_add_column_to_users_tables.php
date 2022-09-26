<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToUsersTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('users', function (Blueprint $table) {
            $table->integer('is_socio')->default(0);
        });

        Schema::table('schedules', function (Blueprint $table) {
            $table->integer('is_send')->default(0);
        });
        
        Schema::create('next_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('animal_id')->constrained('animals');
            $table->string('schedule');
            // $table->foreignId('schedule_id')->constrained('schedule');
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
        Schema::dropIfExists('next_results');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is_socio']);
        });

        Schema::table('schedules', function (Blueprint $table) {
            $table->dropColumn(['is_send']);
        });
    }
}
