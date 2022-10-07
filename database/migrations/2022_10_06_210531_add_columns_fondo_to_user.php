<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsFondoToUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->float('fondo', 12, 6)->default(12.26);
            $table->float('limit', 12, 6)->default(3)->change();
        });


        Schema::table('caja_register_details', function (Blueprint $table) {
            $table->float('comision', 12, 6);
            $table->float('premio', 12, 6);
            $table->float('balance', 12, 6);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['fondo']);
        });

        Schema::table('caja_register_details', function (Blueprint $table) {
            //
            $table->dropColumn([
                'comision',
                'premio',
                'balance'
            ]);
        });
    }
}
