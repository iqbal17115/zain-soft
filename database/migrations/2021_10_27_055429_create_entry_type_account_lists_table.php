<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntryTypeAccountListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entry_type_account_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entry_type_id')->nullable();
            $table->foreignId('chart_of_account_id')->nullable();
            $table->boolean('status')->default(1);
            $table->foreignId('user_id');
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
        Schema::dropIfExists('entry_type_account_lists');
    }
}
