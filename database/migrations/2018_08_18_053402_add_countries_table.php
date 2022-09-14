<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('continent_id')->unsigned();
            $table->char('code', 2);
            $table->string('name', 100);
            $table->boolean('is_active')->default(false);

            // constraints
            $table->unique(['code', 'continent_id']);
            $table->foreign('continent_id')
                ->references('id')
                ->on('continents');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('countries');
    }
}
