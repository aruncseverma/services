<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostCategoryDescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_category_descriptions', function (Blueprint $table) {
            $table->integer('category_id')->unsigned();
            $table->char('lang_code', 4);
            $table->string('name');
            $table->text('description')->nullable();

            $table->unique(['category_id', 'lang_code']);
            $table->foreign('category_id')
                ->references('id')
                ->on('post_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_category_descriptions');
    }
}
