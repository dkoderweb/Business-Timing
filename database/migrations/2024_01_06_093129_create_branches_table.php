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
            $table->unsignedBigInteger('business_id');
            $table->foreign('business_id')->references('id')->on('businesses')->onDelete('cascade');
            $table->string('name');
            $table->json('sunday_timing');
            $table->json('monday_timing');
            $table->json('tuesday_timing');
            $table->json('wednesday_timing');
            $table->json('thursday_timing');
            $table->json('friday_timing');
            $table->json('saturday_timing');
            $table->json('date_close')->nullable();
            $table->json('images'); 
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
        Schema::dropIfExists('branches');
    }
}
