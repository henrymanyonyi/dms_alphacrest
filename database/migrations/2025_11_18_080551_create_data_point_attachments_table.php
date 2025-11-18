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
        Schema::create('data_point_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('data_point_id')->constrained()->cascadeOnDelete();

            $table->string('file_name');
            $table->string('file_path');
            $table->string('file_type')->nullable(); // pdf, xlsx, png, csv
            $table->bigInteger('file_size')->nullable();
            $table->string('description')->nullable();

            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_point_attachments');
    }
};
