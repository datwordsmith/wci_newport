<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->boolean('repeat_monthly')->default(false)->after('created_by');
            $table->tinyInteger('repeat_week_of_month')->nullable()->after('repeat_monthly'); // 1..5
            $table->tinyInteger('repeat_day_of_week')->nullable()->after('repeat_week_of_month'); // 0=Sun..6=Sat
            $table->date('repeat_until')->nullable()->after('repeat_day_of_week');
            $table->unsignedBigInteger('parent_event_id')->nullable()->after('repeat_until');

            $table->index('parent_event_id');
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropIndex(['parent_event_id']);
            $table->dropColumn(['repeat_monthly','repeat_week_of_month','repeat_day_of_week','repeat_until','parent_event_id']);
        });
    }
};
