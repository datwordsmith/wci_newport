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
        Schema::create('sunday_services', function (Blueprint $table) {
            $table->id();
            $table->string('sunday_theme');
            $table->string('sunday_poster')->nullable();
            $table->string('poster_mime_type')->nullable();
            $table->dateTime('service_date');
            $table->time('service_time');
            $table->string('user_email'); // Email of user who created/updated the service
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sunday_services');
    }
};
