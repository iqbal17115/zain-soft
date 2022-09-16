<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('code', 100);
            $table->enum('type', ['Customer', 'Supplier', 'Staff', 'Others']);
            $table->string('name', 191);
            $table->string('business_name', 191)->nullable();
            $table->text('address')->nullable();
            $table->string('email', 191)->nullable();
            $table->string('mobile', 100)->nullable();
            $table->string('trn_no', 191)->nullable();
            $table->string('sale_commission', 100)->nullable();
            $table->string('is_due_sale', 100)->nullable();
            $table->tinyInteger('is_default')->nullable();
            $table->string('credit_limit', 100)->nullable();
            $table->string('telephone', 20)->nullable();
            $table->string('country', 50)->nullable();
            $table->string('division', 50)->nullable();
            $table->double('credit_period', 10, 2)->nullable();
            $table->enum('vat_reg_type', ['Registered', 'Unregistered'])->nullable();
            $table->date('vat_reg_date')->nullable();
            $table->date('due_date')->nullable();
            $table->string('bank_details')->nullable();
            $table->string('website')->nullable();
            $table->double('opening_balance', 20, 4)->nullable()->default(0.00);
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
        Schema::dropIfExists('contacts');
    }
}
