<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{

    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone_number', 10);
            $table->string('password');
            $table->foreignId('group_id')->nullable()->constrained();
            $table->string('home')->nullable();
            $table->dateTime('last_login_at')->nullable();
            $table->string('last_login_ip', 30)->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }


    public function down()
    {
        Schema::dropIfExists('users');
    }
}
