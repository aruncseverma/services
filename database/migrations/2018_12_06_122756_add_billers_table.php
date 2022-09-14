<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBillersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 30);
            $table->string('logo', 100);
            $table->string('adminurl', 100)->nullable();
            $table->string('apiurl', 100)->nullable();
            $table->string('supported', 100)->nullable();
            $table->string('apiuser', 30)->nullable();
            $table->string('apipass', 100)->nullable();
            $table->string('apikey1', 100)->nullable();
            $table->string('apikey2', 100)->nullable();
            $table->text('billnote')->nullable();
            $table->integer('rank');
            $table->boolean('is_active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('billers');
    }
}
