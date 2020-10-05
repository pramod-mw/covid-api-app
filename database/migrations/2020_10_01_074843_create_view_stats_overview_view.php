<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewStatsOverviewView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement("
            CREATE VIEW view_statsoverview 
            AS
            SELECT
                SUM(tested) as total_tested,
                SUM(confirmed) as total_confirmed,
                SUM(recovered) as total_recovered,
                SUM(deaths) as total_deaths,
                MAX(updated_at) as updated_at
            FROM
                api_stats
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('view_statsoverview');
    }
}
