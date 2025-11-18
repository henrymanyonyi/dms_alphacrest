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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique()->index();

            // User info
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('customer_email');
            $table->string('customer_phone')->nullable();

            // Data Point
            $table->foreignId('data_point_id')->constrained()->cascadeOnDelete();

            // Payment details
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('KES');
            $table->enum('payment_method', ['mpesa', 'card', 'paypal'])->default('mpesa');
            $table->enum('status', ['pending', 'completed', 'failed', 'refunded'])->default('pending');

            // Transaction details
            $table->string('transaction_id')->nullable();
            $table->string('mpesa_receipt')->nullable();
            $table->text('payment_details')->nullable(); // JSON for additional info

            // Download tracking
            $table->integer('download_count')->default(0);
            $table->timestamp('last_downloaded_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
