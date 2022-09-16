<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('code', 100);
            $table->date('date')->nullable();
            $table->enum('type', ['Sales', 'Sales Return', 'Purchase', 'Purchase Return', 'Quotation', 'Requisition']);
            $table->foreignId('contact_id')->nullable()->constrained('contacts');
            $table->foreignId('invoice_id')->nullable();
            $table->string('chalan_no', 191)->nullable();
            $table->string('memo_no', 191)->nullable();
            $table->text('header_content')->nullable();
            $table->text('footer_content')->nullable();
            $table->string('attachment', 191)->nullable();
            // $table->text('note')->nullable();
            $table->string('lpo_no', 191)->nullable();
            $table->string('do_no', 191)->nullable();
            $table->double('discount', 20, 4)->nullable();
            $table->string('discount_value', 191)->nullable();
            $table->double('total_vat', 20, 4)->nullable();
            $table->double('shipping_charge', 20, 4)->nullable();
            $table->date('expired_date', 191)->nullable();
            $table->double('subtotal', 20, 4)->nullable();
            $table->double('amount_to_pay', 20, 4)->nullable();
            $table->double('paid_amount', 20, 4)->nullable();
            $table->double('due_amount', 20, 4)->nullable();
            $table->double('note', 20, 4)->nullable();
            $table->date('due_date')->nullable();
            $table->double('advance_amount', 20, 4)->nullable();
            $table->enum('payment_status', ['Paid', 'Due', 'Advanced', 'Cancel']);
            $table->boolean('status')->default(1);
            $table->foreignId('warehouse_id')->nullable()->constrained('warehouses');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('branch_id')->nullable()->constrained('branches');
            $table->foreignId('company_id')->nullable();
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
        Schema::dropIfExists('invoices');
    }
}
