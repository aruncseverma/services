<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostTagDescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_tag_descriptions', function (Blueprint $table) {
            $table->integer('tag_id')->unsigned();
            $table->char('lang_code', 4);
            $table->string('name');
            $table->text('description')->nullable();

            $table->unique(['tag_id', 'lang_code']);
            $table->foreign('tag_id')
                ->references('id')
                ->on('post_tags');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_tag_descriptions');
    }
}
