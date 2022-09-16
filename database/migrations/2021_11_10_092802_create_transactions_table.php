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
            $table->dateTime('date', 0);
            $table->string('code', 100)->nullable();
            $table->text('codes')->nullable();
            $table->enum('type', ['Receive', 'Payment']);
            $table->double('amount', 20, 2)->default(0)->nullable();
            $table->foreignId('chart_of_account_id')->nullable();
            $table->foreignId('invoice_id')->nullable();
            $table->foreignId('contact_id')->nullable();
            $table->foreignId('company_id')->nullable();
            $table->foreignId('user_id');
            $table->foreignId('invoice_ids')->nullable();
            $table->string('note', 500)->nullable();
            $table->date('due_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
