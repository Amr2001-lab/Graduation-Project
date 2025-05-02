<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('apartment', function (Blueprint $table) {
            $table->string('virutal_tour_path')->nullable();
        });
    }


    public function down(): void
    {
        Schema::table('apartment', function (Blueprint $table) {
            $table->dropColumn('virtual_tour_path');
        });
    }
};
