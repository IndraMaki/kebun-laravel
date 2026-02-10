<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('varieties', function (Blueprint $table) {
            if (!Schema::hasColumn('varieties', 'plant_name_id')) {
                $table->foreignId('plant_name_id')
                    ->after('name')
                    ->constrained('plant_names')
                    ->cascadeOnUpdate()
                    ->restrictOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('varieties', function (Blueprint $table) {
            if (Schema::hasColumn('varieties', 'plant_name_id')) {
                $table->dropConstrainedForeignId('plant_name_id');
            }
        });
    }
};

