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
        Schema::table('testimonies', function (Blueprint $table) {
            // Add feedback and reviewed_at fields
            $table->text('admin_feedback')->nullable()->after('approved_by_email');
            $table->timestamp('reviewed_at')->nullable()->after('admin_feedback');

            // Drop the old boolean field and add new enum status field
            $table->dropColumn('is_approved');
            $table->dropColumn('approved_at');
            $table->enum('status', ['pending', 'approved', 'declined'])->default('pending')->after('reviewed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('testimonies', function (Blueprint $table) {
            // Remove new fields
            $table->dropColumn(['admin_feedback', 'reviewed_at', 'status']);

            // Restore the original boolean field
            $table->boolean('is_approved')->default(false)->after('publish_permission');
            $table->timestamp('approved_at')->nullable()->after('is_approved');
        });
    }
};
