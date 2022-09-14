<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEscortLanguages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('escort_languages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('attribute_id')->unsigned();
            $table->char('proficiency', 1)->default('G'); // E - Expert M - Moderate G - Good

            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->foreign('attribute_id')
                ->references('id')
                ->on('attributes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('escort_languages');
    }
}
