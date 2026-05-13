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
        Schema::create('timelapses', function (Blueprint $table) {
            $table->id();

            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('created_by')->constrained('users');

            $table->timestamp('start_date');
            $table->timestamp('end_date');

            $table->integer('fps')->default(24);

            $table->enum('status', ['queued', 'processing', 'completed', 'failed'])
                ->default('queued');

            $table->string('video_path')->nullable();
            $table->text('error')->nullable();

            $table->timestamps();

            $table->index(['project_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timelapses');
    }
};
