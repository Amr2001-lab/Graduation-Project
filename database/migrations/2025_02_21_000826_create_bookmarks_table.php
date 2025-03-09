<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookmarksTable extends Migration
{
    public function up()
    {
        Schema::create('bookmarks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('apartment_id');
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');

            // Note: Use the singular table name "apartment" to match your actual table.
            $table->foreign('apartment_id')
                  ->references('id')->on('apartment')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bookmarks');
    }
}
