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
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 10)->unique();
            $table->text('address');
            $table->string('city');
            $table->string('state');
            $table->string('postal_code', 20);
            $table->string('phone');
            $table->string('email');
            $table->unsignedBigInteger('manager_id')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->date('established_date');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};