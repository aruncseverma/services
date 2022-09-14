<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('post_id')->unsigned();
            $table->text('content');
            $table->boolean('is_approved')->default(false);
            $table->integer('parent_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('name');
            $table->string('email', 100);
            $table->string('url', 200)->nullable();
            $table->string('ip', 100);
            $table->string('agent');
            $table->timestamps();

            $table->foreign('post_id')
                ->references('id')
                ->on('posts');

            $table->index('post_id');
            $table->index('parent_id');
            $table->index('created_at');
            $table->index(['name', 'email']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_comments');
    }
}
