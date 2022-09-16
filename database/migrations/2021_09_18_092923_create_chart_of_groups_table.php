<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChartOfGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chart_of_groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chart_of_section_id')->nullable();
            $table->string('code', 100);
            $table->string('name', 191);
            $table->foreignId('user_id')->constrained('users');
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
        Schema::dropIfExists('chart_of_groups');
    }
}
