<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('data_points', function (Blueprint $table) {
            $table->id();

            // Core identity
            $table->string('name')->index();
            $table->string('slug')->unique()->index();
            $table->longText('description')->nullable();

            // Metadata fields you already had
            $table->text('data_source')->nullable();
            $table->text('data_indicator')->nullable();

            // Activity status
            $table->boolean('is_active')->default(true);
            $table->decimal('price', 10, 2)->default(100.00);

            // Integrated value fields (single latest value)
            $table->string('source_url')->nullable();
            $table->timestamp('data_date')->nullable(); // for exact data collection date

            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('data_parameter_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_points');
    }
};
