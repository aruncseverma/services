<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyColumnsToEscortRankingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('escort_ranking', function (Blueprint $table) {
            $table->dropTimestamps();
        });

        Schema::table('escort_ranking', function (Blueprint $table) {
            $table->integer('total')->default(0);
            $table->datetime('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('escort_ranking', function (Blueprint $table) {
            $table->dropColumn(['total', 'created_at']);
        });

        Schema::table('escort_ranking', function (Blueprint $table) {
            $table->timestamps();
        });
    }
}
