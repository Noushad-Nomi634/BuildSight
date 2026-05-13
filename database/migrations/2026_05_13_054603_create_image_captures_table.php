<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('image_captures', function (Blueprint $table) {
            $table->id();

            $table->foreignId('camera_id')->constrained()->cascadeOnDelete();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();

            $table->string('file_path');
            $table->string('thumbnail_path')->nullable();

            $table->timestamp('captured_at');

            $table->timestamps();

            $table->index(['camera_id', 'captured_at']);
            $table->index(['project_id', 'captured_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('image_captures');
    }
};
