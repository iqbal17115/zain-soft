<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_settings', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['Invoice', 'Receipt']);
            $table->string('logo', 191)->nullable();
            $table->string('invoice_header', 191)->nullable();
            $table->string('invoice_title', 191)->nullable();
            $table->string('invoice_footer')->nullable();
            $table->string('vat_reg_no', 191)->nullable();
            $table->string('vat_area_code', 191)->nullable();
            $table->string('vat_text', 191)->nullable();
            $table->tinyInteger('is_previous_due')->nullable();
            $table->foreignId('currency_id')->nullable()->constrained('currencies');
            $table->string('email', 191)->nullable();
            $table->text('header_title')->nullable();
            $table->text('footer_title')->nullable();
            $table->tinyInteger('is_paid_due_hide')->nullable();
            $table->tinyInteger('is_memo_no_hide')->nullable();
            $table->tinyInteger('is_chalan_no_hide')->nullable();
            $table->tinyInteger('transaction')->nullable();
            $table->tinyInteger('do_no')->nullable();
            $table->tinyInteger('lpo_no')->nullable();
            $table->tinyInteger('vat')->nullable();
            $table->tinyInteger('rate')->nullable();
            $table->tinyInteger('discount')->nullable();
            $table->tinyInteger('amount_aed')->nullable();
            $table->tinyInteger('texable_value')->nullable();
            $table->tinyInteger('vat_aed')->nullable();
            $table->tinyInteger('note')->nullable();
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
        Schema::dropIfExists('invoice_settings');
    }
}
