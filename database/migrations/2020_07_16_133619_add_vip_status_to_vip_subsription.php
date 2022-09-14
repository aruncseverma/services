<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVipStatusToVipSubsription extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vip_subscriptions', function (Blueprint $table) {
            $table->string('vip_status')->default('P');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vip_subscriptions', function(Blueprint $table) {
            $table->dropColumn('vip_status');
        });
    }
}
