<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApartmentsTable extends Migration
{
    public function up()
    {
        Schema::create('apartment', function (Blueprint $table) {
            $table->id();
            // Do not add seller_id here if you'll add it later via a separate migration.
            $table->unsignedInteger('size');
            $table->decimal('price', 10, 2);
            $table->string('street');
            $table->string('city');
            $table->unsignedInteger('age')->nullable();
            $table->unsignedInteger('rooms')->nullable();
            $table->unsignedInteger('bathrooms')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('apartment');
    }
}
