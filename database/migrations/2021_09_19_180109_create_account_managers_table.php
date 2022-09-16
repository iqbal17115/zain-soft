<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountManagersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_managers', function (Blueprint $table) {
            $table->id();
            $table->string('code', 100)->nullable();
            $table->enum('type', ['Debit', 'Credit']);
            $table->foreignId('dr_account_id')->nullable();
            $table->foreignId('cr_account_id')->nullable();
            $table->foreignId('transaction_id')->nullable();
            $table->foreignId('invoice_id')->nullable()->constrained('invoices');
            $table->foreignId('receipt_id')->nullable();
            $table->foreignId('item_id')->nullable();
            $table->foreignId('contact_id')->nullable()->constrained('contacts');
            $table->double('amount', 20, 4)->default(0)->nullable();
            $table->date('date')->nullable();
            $table->date('due_date')->nullable();
            $table->string('note', 500)->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('branch_id')->nullable()->constrained('branches');
            $table->foreignId('company_id')->nullable();
            $table->boolean('status')->default(1);
            $table->enum('payment_status',['Hold', 'Active', 'Inactive'])->nullable();
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
        Schema::dropIfExists('account_managers');
    }
}
