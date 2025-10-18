<?php

namespace Database\Migrations;

use TheFramework\App\Schema;

class Migration_2025_09_23_025917_CreateUsersTable {
    public function up()
    {
        Schema::create('users', function ($table) {
            $table->increments('id');
            $table->string('uid', 36)->unique();

            $table->string('avatar')->nullable();
            $table->string('full_name');
            $table->string('phone_number')->nullable();
            $table->string('faculty_uid', 36);
            $table->string('study_uid', 36);
            $table->integer('semester')->nullable();
            $table->string('password');

            $table->enum('gender', ['Male', 'Female'])->nullable();
            $table->string('email')->unique();
            $table->string('student_staff_id')->unique();
            $table->string('position');
            $table->string('initials');

            $table->string('role_uid', 36);
            $table->string('id_card');

            $table->enum('status', [1, 0]);
            $table->timestamps();
            
            $table->foreign('faculty_uid')->references('uid')->on('faculties')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('study_uid')->references('uid')->on('program_studies')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('role_uid')->references('uid')->on('roles')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}