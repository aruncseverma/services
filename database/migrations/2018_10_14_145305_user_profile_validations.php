<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserProfileValidations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // delete previous table name
        Schema::dropIfExists('membership_requests');

        Schema::create('user_profile_validations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('user_group_id')->unsigned();
            $table->boolean('is_approved')->default(false);
            $table->boolean('is_denied')->default(false);
            $table->json('data');
            $table->timestamps();

            $table->index(['id', 'is_approved', 'is_denied']);
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
            $table->foreign('user_group_id')
                ->references('id')
                ->on('user_groups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_profile_validations');
        // should be removed
        Schema::dropIfExists('membership_requests');
    }
}
