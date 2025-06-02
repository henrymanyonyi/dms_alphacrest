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
        Schema::create('data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('data_segment_id')->nullable()->constrained()->onDelete('cascade');
            $table->uuid('data_ref')->unique();
            $table->text('title');
            $table->date('historical_start')->nullable();
            $table->date('historical_end')->nullable();
            $table->json('metadata')->nullable();
            $table->text('report_summary')->nullable();
            $table->text('table_of_contents')->nullable();
            $table->text('segmentations')->nullable();
            $table->json('reference_links')->nullable();
            $table->json('attachments')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('deleted_by')->nullable()->constrained('users');
            $table->boolean('approval_status')->default(false);
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->integer('view_count')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data');
    }
};
