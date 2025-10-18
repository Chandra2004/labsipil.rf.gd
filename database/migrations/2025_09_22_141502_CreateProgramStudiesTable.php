<?php

namespace Database\Migrations;

use TheFramework\App\Schema;

class Migration_2025_09_22_141502_CreateProgramStudiesTable {
    public function up()
    {
        Schema::create('program_studies', function ($table) {
            $table->increments('id');
            $table->string('uid', 36)->unique();

            $table->string('faculty_uid', 36);
            $table->string('name_study');
            $table->string('educational_level');
            $table->string('acreditation_study');
            
            $table->timestamps();

            $table->foreign('faculty_uid')->references('uid')->on('faculties')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('program_studies');
    }
}