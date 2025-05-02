<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('apartment', function (Blueprint $table) {
            $table->renameColumn('virtual', 'virtual_tour_path');
        });
    }

    public function down(): void
    {
        Schema::table('apartment', function (Blueprint $table) {
            $table->renameColumn('virtual_tour_path', 'virtual_tour_path');
        });
    }
};
