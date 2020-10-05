<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApiStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_stats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date')->unique();
            $table->integer('tested')->default('0');
            $table->integer('confirmed')->default('0');
            $table->integer('recovered')->default('0');
            $table->integer('deaths')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('api_stats');
    }
}
