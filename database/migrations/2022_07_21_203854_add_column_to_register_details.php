<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToRegisterDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('register_details', function (Blueprint $table) {
            $table->integer('user_id');
            $table->integer('caja_id');
            $table->integer('status')->default(0);
        });

        Schema::table('cajas', function (Blueprint $table) {
            $table->integer('admin_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('register_details', function (Blueprint $table) {
            $table->dropColumn(['status', 'user_id','caja_id']);
        });

        Schema::table('cajas', function (Blueprint $table) {
            $table->dropColumn(['admin_id']);
        });
    }
}
