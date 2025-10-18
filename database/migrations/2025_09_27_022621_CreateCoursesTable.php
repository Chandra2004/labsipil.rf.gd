<?php

namespace Database\Migrations;

use TheFramework\App\Schema;

class Migration_2025_09_27_022621_CreateCoursesTable {
    public function up()
    {
        Schema::create('courses', function ($table) {
            $table->increments('id');
            $table->string('uid', 36)->unique();
            
            $table->string('code_course');
            $table->string('name_course');
            $table->string('study_course', 36);
            $table->integer('semester_course');
            $table->text('description_course');
            $table->string('link_course');

            $table->string('author_course', 36);

            $table->timestamps();

            $table->foreign('study_course')->references('uid')->on('program_studies')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('author_course')->references('uid')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('courses');
    }
}