<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('code', 100);
            $table->string('title', 100);
            $table->string('symbol', 100);
            $table->enum('symbol_position', ['Prefix', 'Surfix'])->nullable();
            $table->string('in_word_prefix', 100)->nullable();
            $table->string('in_word_surfix', 100)->nullable();
            $table->enum('in_word_prefix_position', ['Prefix', 'Surfix'])->nullable();
            $table->enum('in_word_surfix_position', ['Prefix', 'Surfix'])->nullable();
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
        Schema::dropIfExists('currencies');
    }
}
