<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\Types\Nullable;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id') //client
                ->constrained()
                ->cascadeOnDelete();
            $table->string('name');
            $table->string('project_code')->nullable();
            $table->text('description')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->string('address_1')->nullable();
            $table->string('address_2')->nullable();
            $table->string('country')->nullable();
            $table->string('state_province')->nullable();
            $table->string('postal_code')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('alerts_email')->nullable();
            $table->enum('status', ['active', 'planning', 'on_hold', 'completed', 'cancelled'])
                ->default('active');
            $table->enum('priority', ['medium', 'high', 'low', 'urgent'])
                ->default('low');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            $table->index(['company_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
