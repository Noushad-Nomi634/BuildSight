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
        Schema::create('cameras', function (Blueprint $table) {
            $table->id();

            $table->foreignId('project_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('name');
            $table->string('ip_address')->nullable();
            $table->integer('port')->default(80);

            $table->string('username')->nullable();
            $table->text('password')->nullable();

            $table->string('snapshot_url')->nullable();

            $table->enum('upload_method', ['ftp', 'http', 'onvif'])
                ->default('ftp');

            $table->boolean('is_active')->default(true);

            $table->timestamp('last_seen_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cameras');
    }
};
