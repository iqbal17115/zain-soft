<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChartOfAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chart_of_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('code', 100)->nullable();
            $table->string('name', 100)->nullable();
            $table->string('value', 100)->nullable();
            $table->enum('type', ['Debit', 'Credit'])->nullable();
            $table->double('opening_balance', 10, 2)->default(0.00)->nullable();
            $table->foreignId('chart_of_group_id')->nullable();
            $table->tinyInteger('is_cashbank')->nullable();
            $table->tinyInteger('is_income_statement')->nullable();
            $table->tinyInteger('is_balance_sheet')->nullable();
            $table->tinyInteger('default_module')->nullable();
            $table->text('note')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('company_id')->nullable();
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('chart_of_accounts');
    }
}
