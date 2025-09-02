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
        Schema::create('testimonies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('author');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('result_category');
            $table->date('testimony_date')->nullable();
            $table->json('engagements')->nullable(); // Store selected engagements as JSON
            $table->text('content');
            $table->boolean('publish_permission')->default(false);
            $table->boolean('is_approved')->default(false); // Admin approval field
            $table->timestamp('approved_at')->nullable();
            $table->string('approved_by_email')->nullable(); // Email of admin who approved
            $table->timestamps();

            // Indexes for better performance
            $table->index(['is_approved', 'created_at']);
            $table->index('result_category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonies');
    }
};
