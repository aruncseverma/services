<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEscortReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('escort_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('escort_user_id')->unsigned();
            $table->integer('customer_user_id')->unsigned();
            $table->string('type', 25);
            $table->string('content', 255);
            $table->timestamps();

            $table->foreign('escort_user_id')
                ->references('id')
                ->on('users');
            $table->foreign('customer_user_id')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('escort_reports');
    }
}
