<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePackagesCurrency extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // First fix the currencies table if needed.
        // we hardcode the values based on table id (1=USD, 2=EUR)
        DB::table('currencies')->where('id', 1)->update(['symbol_right' => '$']);
        DB::table('currencies')->where('id', 2)->update(['code' => 'EUR', 'symbol_left' => '€']);

        Schema::table('packages', function (Blueprint $table) {
          // Add column connected to currencies table.
          $table->unsignedInteger('currency_id')->after('biller_id');
        });

        // Select old currencies column to migrate to new
        $results = DB::table('packages')->select('id','currency')->get();

        foreach($results as $result) 
        {
          $currency = DB::table('currencies')->select('id')->where('code', '=', $result->currency)->first();
          DB::table('packages')->where('id',$result->id)->update(['currency_id'=>$currency->id]);
        }

        Schema::table('packages', function (Blueprint $table) {
          $table->dropColumn('currency');
          $table->foreign('currency_id')->references('id')->on('currencies');
        });        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('packages', function (Blueprint $table) {
          $table->string('currency', 10)->after('biller_id');
          $table->dropForeign(['currency_id']);
        });

        // Select new currencies column to migrate to old
        $results = DB::table('packages')->select('id','currency_id')->get();

        foreach($results as $result) 
        {
          $currency = DB::table('currencies')->select('code')->where('id', '=', $result->currency_id)->first();
          DB::table('packages')->where('id',$result->id)->update(['currency'=>$currency->code]);
        }

        Schema::table('packages', function (Blueprint $table) {
          $table->dropColumn('currency_id');
        });
    }
}
