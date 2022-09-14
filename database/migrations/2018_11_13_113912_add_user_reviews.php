<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserReviews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // new table
        Schema::create('user_reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('object_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('content', 255);
            $table->decimal('rating', 2, 1)->default(0);
            $table->boolean('is_approved')->default(false);
            $table->boolean('is_denied')->default(false);
            $table->timestamps();

            $table->index(['object_id', 'user_id', 'is_denied', 'is_approved']);
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
        Schema::dropIfExists('user_reviews');
    }
}
