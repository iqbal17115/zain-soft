<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('entry_type_id');
            $table->string('code', 100)->nullable();
            $table->double('amount', 20, 2)->default(0)->nullable();
            $table->foreignId('contact_id')->nullable();
            $table->foreignId('invoice_id')->nullable();
            $table->foreignId('approved_id')->nullable();
            $table->timestamp('is_approved')->nullable();
            $table->foreignId('checked_id')->nullable();
            $table->timestamp('is_checked')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->dateTime('date', 0);
            $table->text('note')->nullable();
            $table->foreignId('tag_id')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('branch_id')->nullable();
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
        Schema::dropIfExists('receipts');
    }
}
