<?php

namespace Database\Migrations;

use TheFramework\App\Schema;

class Migration_2025_09_23_025347_CreateRolesTable {
    public function up()
    {
        Schema::create('roles', function ($table) {
            $table->increments('id');
            
            $table->string('uid', 36)->unique();
            $table->string('role_name');
            $table->string('role_description')->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('roles');
    }
}