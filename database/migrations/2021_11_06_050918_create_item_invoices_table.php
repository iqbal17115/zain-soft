<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('code', 100);
            $table->date('date')->nullable();
            $table->foreignId('item_id')->nullable()->constrained('items');
            $table->foreignId('invoice_id')->nullable()->constrained('invoices');
            $table->foreignId('category_id')->nullable()->constrained('categories');
            $table->foreignId('unit_id')->nullable()->constrained('units');
            $table->foreignId('contact_id')->nullable()->constrained('contacts');
            $table->string('warranty', 191)->nullable();
            $table->string('serial', 191)->nullable();
            $table->string('quantity', 191)->nullable();
            $table->double('purchase_price', 20, 4)->nullable();
            $table->double('sale_price', 20, 4)->nullable();
            $table->double('discount_percent', 20, 4)->nullable();
            $table->double('discount_value', 20, 4)->nullable();
            $table->double('vat', 20, 4)->nullable();
            $table->double('vat_subtotal', 20, 4)->nullable();
            $table->double('subtotal', 20, 4)->nullable();
            $table->string('batch_no', 191)->nullable();
            $table->date('expired_date', 191)->nullable();
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
        Schema::dropIfExists('item_invoices');
    }
}
