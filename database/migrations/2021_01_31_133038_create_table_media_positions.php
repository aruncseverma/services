<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableMediaPositions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_positions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type')->default('P');
            $table->integer('media_id');
            $table->integer('position')->default(0);
            $table->integer('user_id')->unsigned();
            $table->integer('folder_id')->default(0);
            $table->timestamps();

            $table->foreign('user_id')
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
        Schema::dropIfExists('media_positions');
    }
}
