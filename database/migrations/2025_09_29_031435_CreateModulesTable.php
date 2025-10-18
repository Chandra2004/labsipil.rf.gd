<?php

namespace Database\Migrations;

use TheFramework\App\Schema;

class Migration_2025_09_29_031435_CreateModulesTable {
    public function up()
    {
        Schema::create('modules', function ($table) {
            $table->increments('id');
            $table->string('uid', 36)->unique();

            $table->string('course_uid', 36);
            $table->string('file_module');
            $table->string('code_module')->nullable();
            $table->string('name_module');
            $table->text('description_module')->nullable();
            $table->date('date_module')->nullable();

            $table->timestamps();

            $table->foreign('course_uid')->references('uid')->on('courses')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('modules');
    }
}