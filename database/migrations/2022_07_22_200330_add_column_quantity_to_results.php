<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnQuantityToResults extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('results', function (Blueprint $table) {
            //
            $table->float('quantity_plays',12,6)->nullable();
            $table->float('quantity_winners',12,6)->nullable();
            $table->float('quantity_lossers',12,6)->nullable();
            $table->float('amount_winners_usd',12,6)->nullable();
            $table->float('amount_home_usd',12,6)->nullable();
            $table->float('amount_balance_usd',12,6)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('results', function (Blueprint $table) {
            //
            $table->dropColumn([
                'quantity_plays',
                'quantity_winners',
                'quantity_lossers',
                'amount_winners_usd',
                'amount_home_usd',
                'amount_balance_usd',
            ]);
        });
    }
}
