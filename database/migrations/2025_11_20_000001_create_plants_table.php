<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('plants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('latin_name')->nullable();
            $table->text('description')->nullable();
            $table->text('benefits')->nullable();
            $table->text('care')->nullable();
            $table->string('main_photo_url')->nullable();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnUpdate()->restrictOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plants');
    }
};