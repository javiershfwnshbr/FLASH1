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
        Schema::create('uploads', function (Blueprint $table) {
            $table->id();
            $table->string('filename');
            $table->string('original_name');
            $table->string('filesize');
            $table->string('resolution');
            $table->string('verdict');
            $table->decimal('ai_score', 5, 2);
            $table->string('camera_model')->default('-');
            $table->string('date_taken')->default('-');
            $table->string('time_taken')->default('-');
            $table->string('gps_coordinates')->default('-');
            $table->string('social_media')->default('-');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uploads');
    }
};
