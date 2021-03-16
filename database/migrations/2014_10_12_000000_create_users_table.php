<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;

class CreateUsersTable extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email_address')->unique()->comments("Email address");
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->comments("minimum 6 characters long");
            $table->integer('user_type')->default(0)->comments('0: Web user, 1: Admin');
            $table->string("status")->nullable();
            $table->rememberToken();
            $table->timestamps();
        });


         DB::table('users')->insert(
                                    array(
                                            [
                                                'first_name' => 'Bangla', 
                                                'last_name' => '71', 
                                                'email_address' => 'admin@gmail.com', 
                                                'password' => Hash::make('Bangla71'), 
                                                'user_type' => 1, // Admin
                                            ]
                                    )
                                ); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('users');
    }
}



