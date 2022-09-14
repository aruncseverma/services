<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_locations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->char('type', 1)->default('A'); // M - Main A-Additional
            $table->integer('continent_id')->unsigned();
            $table->integer('country_id')->unsigned();
            $table->integer('state_id')->unsigned();
            $table->integer('city_id')->unsigned();

            $table->foreign('user_id')
                ->references('id')
                ->on('users');
            $table->foreign('continent_id')
                ->references('id')
                ->on('continents');
            $table->foreign('country_id')
                ->references('id')
                ->on('countries');
            $table->foreign('state_id')
                ->references('id')
                ->on('states');
            $table->foreign('city_id')
                ->references('id')
                ->on('cities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_locations');
    }
}
