<?php

namespace Database\Migrations;

use TheFramework\App\Schema;

class Migration_2025_09_22_141426_CreateFacultiesTable {
    public function up()
    {
        Schema::create('faculties', function ($table) {
            $table->increments('id');
            $table->string('uid', 36)->unique();
            
            $table->string('code_faculty');
            $table->string('name_faculty');
            $table->string('description_faculty');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('faculties');
    }
}