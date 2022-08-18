<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSorteosTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sorteos_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::table('animals', function (Blueprint $table) {
            $table->unsignedBigInteger('sorteo_type_id')->default(1);
        });

        Schema::table('register_details', function (Blueprint $table) {
            $table->unsignedBigInteger('sorteo_type_id')->default(1);
        });

        Schema::table('results', function (Blueprint $table) {
            $table->unsignedBigInteger('sorteo_type_id')->default(1);
        });

        Schema::table('schedules', function (Blueprint $table) {
            $table->unsignedBigInteger('sorteo_type_id')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('animals', function (Blueprint $table) {
            $table->dropColumn([
                'sorteo_type_id',
            ]);
        });
        Schema::table('register_details', function (Blueprint $table) {
            $table->dropColumn([
                'sorteo_type_id',
            ]);
        });
        Schema::table('results', function (Blueprint $table) {
            $table->dropColumn([
                'sorteo_type_id',
            ]);
        });
        Schema::table('schedules', function (Blueprint $table) {
            $table->dropColumn([
                'sorteo_type_id',
            ]);
        });

        Schema::dropIfExists('sorteos_types');
    }
}
