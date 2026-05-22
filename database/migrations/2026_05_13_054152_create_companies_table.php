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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
          

            $table->string('name');
            $table->text('description')->nullable();

            $table->string('logo')->nullable();

            $table->string('email')->unique();

            $table->string('phone', 20)->nullable();
            $table->string('mobile', 20)->nullable();

            $table->string('website')->nullable();

            $table->string('address_1')->nullable();
            $table->string('address_2')->nullable();
            $table->foreignId('country_id')->nullable()->constrained('countries')->nullOnDelete();
            $table->string('state_province')->nullable();
            $table->string('postal_code')->nullable();

            $table->enum('status', ['active', 'inactive'])->default('active');

            $table->foreignId('created_by')
                ->constrained('users')
                ->restrictOnDelete();

            $table->timestamps();

            $table->index(['status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
