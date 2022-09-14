<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('biller_id')->unsigned();
            $table->string('currency', 10);
            $table->integer('credits');
            $table->decimal('discount', 5, 2);
            $table->decimal('price', 8, 2);
            $table->boolean('is_active');
        });

        Schema::table('packages', function (Blueprint $table) {
            $table->foreign('biller_id')->references('id')->on('billers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('packages');
    }
}
