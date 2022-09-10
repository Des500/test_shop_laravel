<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_id');
            $table->string('payment_system');
            $table->string('payment_method');
            $table->string('transction_id');
            $table->float('summa_order');             // withdraw_amount сумма оплаченная покупателем
            $table->float('commission');
            $table->float('amount');                      // amount сумма полученная в кошелек (сумма заказа -комиссия системы)
            $table->boolean('istest')->default(false);
            $table->boolean('exported')->default(false);
            $table->timestamps();
            $table->text('post_content');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
