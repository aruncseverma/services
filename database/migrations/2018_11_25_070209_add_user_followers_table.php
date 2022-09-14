<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserFollowersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_followers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('follower_user_id')->unsigned();
            $table->integer('followed_user_id')->unsigned();
            $table->decimal('follower_user_rating', 2, 1)->default(0);
            $table->decimal('followed_user_rating', 2, 1)->default(0);
            $table->boolean('is_banned')->default(false);
            $table->timestamps();

            $table->foreign('follower_user_id')
                ->references('id')
                ->on('users');
            $table->foreign('followed_user_id')
                ->references('id')
                ->on('users');
            $table->index(['is_banned']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_followers');
    }
}
