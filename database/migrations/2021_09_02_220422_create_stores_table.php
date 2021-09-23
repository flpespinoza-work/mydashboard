<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresTable extends Migration
{

    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->nullable()->constrained();
            $table->string('name', 100)->unique();
            $table->integer('node')->unique()->nullable();
            $table->string('giftcard')->unique()->nullable();
            $table->string('budget')->unique()->nullable();
            $table->string('phone', 10)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('contact_name', 100)->nullable();
            $table->string('address')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('stores');
    }
}
