<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMerchantIdToStores extends Migration
{
    public function up()
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->integer('merchant_id')->after('budget');
        });
    }

    public function down()
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->dropColumn('merchant_id');
        });
    }
}
