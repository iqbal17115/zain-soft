<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('code', 100)->nullable();
            $table->string('name', 100)->nullable();
            $table->string('address', 100)->nullable();
            $table->string('telephone', 100)->nullable();
            $table->string('mobile', 100)->nullable();
            $table->string('email',191)->nullable();
            $table->string('postal_code', 191)->nullable();
            $table->string('trn',191)->nullable();
            $table->string('web_address', 100)->nullable();
            $table->string('country', 100)->nullable();
            $table->text('logo')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->enum('status', ['Active', 'Inactive'])->nullable();
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
        Schema::dropIfExists('companies');
    }
}
