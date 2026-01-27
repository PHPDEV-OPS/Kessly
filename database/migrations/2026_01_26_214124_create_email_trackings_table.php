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
        Schema::create('email_trackings', function (Blueprint $table) {
            $table->id();
            $table->string('email_type'); // welcome, admin-notification, verification, etc.
            $table->string('recipient_email');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('tracking_id')->unique(); // Unique identifier for the email
            $table->boolean('opened')->default(false);
            $table->timestamp('opened_at')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('ip_address')->nullable();
            $table->json('metadata')->nullable(); // Additional tracking data
            $table->timestamps();

            $table->index(['email_type', 'opened']);
            $table->index('tracking_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_trackings');
    }
};
