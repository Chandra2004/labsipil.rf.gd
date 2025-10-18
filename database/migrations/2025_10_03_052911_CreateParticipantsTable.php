<?php

namespace Database\Migrations;

use TheFramework\App\Schema;

class Migration_2025_10_03_052911_CreateParticipantsTable {
    public function up()
    {
        Schema::create('participants', function ($table) {
            $table->increments('id');
            $table->string('uid', 36)->unique();
            
            $table->string('user_uid', 36);
            $table->string('course_uid', 36);
            $table->string('session_uid', 36);

            $table->string('koordinator_uid', 36);
            $table->string('asisten_uid', 36);
            $table->string('pembimbing_uid', 36);

            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');

            $table->timestamps();

            $table->foreign('user_uid')->references('uid')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('koordinator_uid')->references('uid')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('asisten_uid')->references('uid')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('pembimbing_uid')->references('uid')->on('users')->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('course_uid')->references('uid')->on('courses')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('session_uid')->references('uid')->on('sessions')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('participants');
    }
}