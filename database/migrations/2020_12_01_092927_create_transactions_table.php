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
            $table->string('customer')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('description')->nullable();
            $table->string('description1')->nullable();
            $table->string('currency')->nullable();
            $table->string('invoice_number')->nullable();
            $table->float('discount')->nullable();
            $table->float('price')->nullable();
            $table->float('price1')->nullable();
            $table->float('amount')->nullable();
            $table->float('amount1')->nullable();
            $table->float('subtotal')->nullable();
            $table->float('total')->nullable();
            $table->float('amount_due')->nullable();
            $table->boolean('paid')->nullable();
            $table->text('url_link')->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
