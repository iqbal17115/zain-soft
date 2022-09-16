<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('code', 100);
            $table->string('name', 100);
            $table->string('email', 100)->nullable();
            $table->string('address', 100);
            $table->text('logo')->nullable();
            $table->string('telephone', 191)->nullable();
            $table->string('web_address', 191)->nullable();
            $table->string('trn_no', 191)->nullable();
            $table->enum('type', ['with_header', 'with_out_header',]);
            $table->string('mobile', 100);
            $table->foreignId('currency_id')->nullable();
            $table->foreignId('user_id')->nullable();
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
        Schema::dropIfExists('branches');
    }
}
