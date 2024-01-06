<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDaysTimingAndSpecificDatesToBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('branches', function (Blueprint $table) {
            // Add columns for days' timing
            $table->json('days_timing')->nullable();
            // Add column for specific dates
            $table->json('specific_dates')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('branches', function (Blueprint $table) {
            // Reverse the changes
            $table->dropColumn('days_timing');
            $table->dropColumn('specific_dates');
        });
    }
}
