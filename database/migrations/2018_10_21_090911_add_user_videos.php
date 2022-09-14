<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserVideos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_videos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->char('visibility', 1)->default('P'); // P - Public, V - Private
            $table->string('path', 1000);
            $table->integer('user_video_folder_id')->unsigned()->nullable();
            $table->timestamps();

            // index
            $table->index(['visibility', 'id']);

            // fk
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
            $table->foreign('user_video_folder_id')
                ->references('id')
                ->on('user_video_folders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_videos');
    }
}
