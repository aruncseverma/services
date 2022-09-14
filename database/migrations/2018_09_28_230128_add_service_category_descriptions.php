<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddServiceCategoryDescriptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_category_descriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('service_category_id')->unsigned();
            $table->string('content', 100);
            $table->char('lang_code', 4);
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();

            $table->foreign('service_category_id')
                ->references('id')
                ->on('service_categories');

            $table->foreign('lang_code')
                ->references('code')
                ->on('languages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_category_descriptions');
    }
}
