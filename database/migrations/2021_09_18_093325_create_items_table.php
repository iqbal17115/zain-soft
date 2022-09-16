<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['Product', 'Material', 'Service']);
            $table->foreignId('category_id')->constrained('categories');
            $table->foreignId('brand_id')->nullable()->constrained('brands');
            $table->string('code', 100);
            $table->string('name', 191);
            $table->foreignId('unit_id')->constrained('units');
            $table->double('purchase_price', 20, 4)->nullable();
            $table->double('avg_pur_price', 20, 4)->nullable();
            $table->double('opening_stock', 20, 4)->nullable();
            $table->foreignId('vat_id')->nullable()->constrained('vats');
            $table->double('discount', 20, 4)->nullable();
            $table->double('sale_price', 20, 4)->nullable();
            $table->double('low_stock_alert', 20, 4)->nullable();
            $table->string('is_stock_check', 100)->nullable();
            $table->double('whole_sale_price', 20, 2)->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('branch_id')->nullable()->constrained('branches');
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
        Schema::dropIfExists('items');
    }
}
