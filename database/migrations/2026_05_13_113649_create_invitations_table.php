<?php
// database/migrations/xxxx_create_invitations_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('company_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('invited_by')
                ->constrained('users')
                ->cascadeOnDelete();

            // Who the invite is for — null until accepted
            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('role_id')
                ->nullable()
                ->constrained()       // spatie roles table
                ->nullOnDelete();

            $table->string('email');
            $table->string('name')->nullable();
            $table->string('token', 64)->unique();

            $table->enum('status', ['pending', 'accepted', 'cancelled', 'expired'])
                ->default('pending');

            $table->timestamp('expires_at');
            $table->timestamp('accepted_at')->nullable();
            $table->timestamp('last_sent_at')->nullable();

            $table->timestamps();

            // One pending invite per email per company
            $table->unique(['company_id', 'email']);
            $table->index(['token', 'status']);
            $table->index(['company_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invitations');
    }
};