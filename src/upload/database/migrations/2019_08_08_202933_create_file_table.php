<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFileTable extends Migration
{
    public function up()
    {
        Schema::create('file', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('storage_id');
            $table->uuid('uuid');
            $table->string('name', 255);
            $table->string('file', 255);
            $table->string('mime_type', 50);
            $table->integer('size');
            $table->string('extension', 255);
            $table->timestamps();
            $table->index('name');
        });
    }

    public function down()
    {
        Schema::drop('file');
    }
}
