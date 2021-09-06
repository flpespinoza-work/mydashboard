<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained();
            $table->string('name', 100)->unique();
            $table->integer('token_node')->unique();
            $table->string('token_giftcard')->unique();
            $table->string('token_budget')->unique();
            $table->string('phone', 10)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('contact_name', 100)->nullable();
            $table->string('address')->nullable();
            $table->unsignedInteger('state_id')->nullable();
            $table->unsignedInteger('municipality_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stores');
    }
}
