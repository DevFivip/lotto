<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCajaRegistersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caja_registers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('users');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('caja_id')->constrained('cajas'); 
            $table->integer('total_tickets_cant');
            $table->timestamps();
        });      
        
        Schema::create('caja_register_details', function (Blueprint $table) {
            $table->id();
            $table->integer('type')->default(1); // 3 values (abono,ventas,retiro)
            $table->string('detalle');
            $table->foreignId('caja_registers_id')->constrained('caja_registers'); 
            $table->foreignId('admin_id')->constrained('users');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('moneda_id')->constrained('monedas'); 
            $table->float('total',12,6);
            $table->float('exchange',12,6);
            $table->float('total_usdt',12,6);
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
        Schema::dropIfExists('caja_registers');
    }
}
