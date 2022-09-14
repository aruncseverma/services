<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email', 255);
            $table->string('username', 100);
            $table->string('password', 100);
            $table->rememberToken();
            $table->string('name')->nullable();
            $table->boolean('is_active')->default(false);
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_newsletter_subscriber')->default(false);
            $table->boolean('is_root')->default(true);
            $table->boolean('is_approved')->default(false);
            $table->boolean('is_blocked')->default(false);
            $table->char('type', 1);
            $table->char('gender', 1)->nullable();
            $table->char('phone', 15)->nullable();
            $table->datetime('birthdate')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // constraints
            $table->unique('email');
            $table->unique('username');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
