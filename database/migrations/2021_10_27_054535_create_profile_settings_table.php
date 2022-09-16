<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfileSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile_settings', function (Blueprint $table) {
            $table->id();
            $table->string('logo', 191)->nullable();
            $table->string('profile_photo', 191)->nullable();
            $table->string('business_name', 191)->nullable();
            $table->string('name', 191);
            $table->string('email', 191)->nullable();
            $table->string('mobile', 191)->nullable();
            $table->string('telephone', 191)->nullable();
            $table->string('trn_no', 191)->nullable();
            $table->string('address', 191)->nullable();
            $table->string('postal_code', 191)->nullable();
            $table->string('city', 191)->nullable();
            $table->string('country', 191)->nullable();
            $table->string('website', 191)->nullable();
            $table->foreignId('user_id')->constrained('users');
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
        Schema::dropIfExists('profile_settings');
    }
}
