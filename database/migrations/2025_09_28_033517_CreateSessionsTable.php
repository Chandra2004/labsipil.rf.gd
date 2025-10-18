<?php

namespace Database\Migrations;

use TheFramework\App\Schema;

class Migration_2025_09_28_033517_CreateSessionsTable {
    public function up()
    {
        Schema::create('sessions', function ($table) {
            $table->increments('id');
            $table->string('uid', 36)->unique();
            
            $table->string('course_uid', 36);
            $table->string('code_session');
            $table->string('name_session');
            $table->time('start_session');
            $table->time('end_session');

            $table->unsignedInteger('kuota_session');

            $table->datetime('open_session');
            $table->datetime('close_session');
            
            $table->timestamps();

            $table->foreign('course_uid')->references('uid')->on('courses')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sessions');
    }
}