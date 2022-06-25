<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\User;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('usr_id');
            $table->string('usr')->unique();
            $table->string('password');
            $table->integer('permissions');
            $table->rememberToken();
            $table->timestamps();
        });

        User::create([
            'usr' => 'Administrator',
            'permissions' => 0,
            'password' => Hash::make("password"),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
