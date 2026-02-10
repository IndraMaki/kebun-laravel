<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('varieties', function (Blueprint $table) {
            if (Schema::hasColumn('varieties', 'plant_id')) {
                $table->dropConstrainedForeignId('plant_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('varieties', function (Blueprint $table) {
            if (!Schema::hasColumn('varieties', 'plant_id')) {
                $table->foreignId('plant_id')
                    ->after('name')
                    ->constrained('plants')
                    ->cascadeOnUpdate()
                    ->restrictOnDelete();
            }
        });
    }
};

