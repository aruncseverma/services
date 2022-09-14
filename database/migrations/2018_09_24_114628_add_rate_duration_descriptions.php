<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRateDurationDescriptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rate_duration_descriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('rate_duration_id')->unsigned();
            $table->char('lang_code', 4);
            $table->string('content', 50);

            $table->foreign('rate_duration_id')
                ->references('id')
                ->on('rate_durations');

            $table->foreign('lang_code')
                ->references('code')
                ->on('languages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rate_duration_descriptions');
    }
}
