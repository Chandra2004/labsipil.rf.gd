<?php

namespace Database\Migrations;

use TheFramework\App\Schema;

class Migration_2025_09_25_060238_CreateNewsTable {
    public function up()
    {
        Schema::create('news', function ($table) {
            $table->increments('id');
            $table->string('uid', 36)->unique();
            
            $table->string('category');
            $table->string('title');
            $table->string('slug');
            $table->text('description');
            $table->string('author', 36);

            $table->datetime('date_time');
            $table->timestamps();

            $table->fullText(['title', 'description']);

            $table->foreign('author')->references('uid')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('news');
    }
}