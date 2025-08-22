<?php

namespace Database\Migrations;

use TheFramework\App\Schema;

class Migration_2025_08_14_045829_CreateUsersTable {
    public function up()
    {
        Schema::create('users', function ($table) {
            $table->id();
            $table->string('uid')->unique();

            $table->text('name', 100);
            $table->text('email')->unique();
            $table->text('password');
            $table->string('profile_picture')->nullable();
            $table->boolean('is_active')->default(1);
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}