<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type', 10);
            $table->integer('from_user_id')->unsigned()->nullable();
            $table->integer('from_wallet_id')->unsigned()->nullable();
            $table->decimal('from_amount', 8, 2)->nullable();
            $table->integer('to_user_id')->unsigned()->nullable();
            $table->integer('to_wallet_id')->unsigned()->nullable();
            $table->decimal('to_amount', 8, 2)->nullable();
            $table->string('status', 10);
            $table->json('note')->nullable();
            $table->timestamps();
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->foreign('from_user_id')->references('id')->on('users');
        });
        Schema::table('transactions', function (Blueprint $table) {
            $table->foreign('from_wallet_id')->references('id')->on('wallets');
        });
        Schema::table('transactions', function (Blueprint $table) {
            $table->foreign('to_user_id')->references('id')->on('users');
        });
        Schema::table('transactions', function (Blueprint $table) {
            $table->foreign('to_wallet_id')->references('id')->on('wallets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
