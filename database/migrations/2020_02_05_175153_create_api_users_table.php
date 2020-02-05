<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApiUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('agentId');
            $table->string('first_name');
            $table->string('sur_name');
            $table->string('email');
            $table->string('login_name');
            $table->string('password');
            $table->string('operatorLevel');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('api_users');
    }
}
