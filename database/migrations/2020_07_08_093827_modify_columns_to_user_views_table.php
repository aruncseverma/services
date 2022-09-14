<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyColumnsToUserViewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_views', function (Blueprint $table) {
            $table->dropColumn('id', 'updated_at');
            $table->string('device_type', 10)->default('');
            $table->string('device', 50)->default('');
            $table->string('platform', 50)->default('');
            $table->string('browser', 50)->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_views', function (Blueprint $table) {
            $table->increments('id');
            $table->datetime('updated_at')->nullable();
            $table->dropColumn(['device_type', 'device', 'platform', 'browser']);
        });
    }
}
