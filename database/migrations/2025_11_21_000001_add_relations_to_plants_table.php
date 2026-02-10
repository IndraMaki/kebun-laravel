<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('plants', function (Blueprint $table) {
            $table->foreignId('plant_name_id')->nullable()->after('qr_code_path')->constrained('plant_names')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('variety_id')->nullable()->after('plant_name_id')->constrained('varieties')->cascadeOnUpdate()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('plants', function (Blueprint $table) {
            $table->dropConstrainedForeignId('plant_name_id');
            $table->dropConstrainedForeignId('variety_id');
        });
    }
};

