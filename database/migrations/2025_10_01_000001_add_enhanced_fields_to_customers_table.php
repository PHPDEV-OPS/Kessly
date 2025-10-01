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
        Schema::table('customers', function (Blueprint $table) {
            $table->string('mobile')->nullable()->after('phone');
            $table->string('company')->nullable()->after('email');
            $table->string('website')->nullable()->after('company');
            $table->text('address')->nullable()->change();
            $table->string('city')->nullable()->after('address');
            $table->string('state')->nullable()->after('city');
            $table->string('postal_code')->nullable()->after('state');
            $table->string('country')->nullable()->after('postal_code');
            $table->string('tax_id')->nullable()->after('country');
            $table->enum('customer_type', ['individual', 'business', 'enterprise'])->default('individual')->after('tax_id');
            $table->enum('status', ['active', 'inactive', 'prospect', 'blocked'])->default('active')->after('customer_type');
            $table->decimal('credit_limit', 15, 2)->default(0)->after('status');
            $table->string('payment_terms')->nullable()->after('credit_limit');
            $table->json('tags')->nullable()->after('notes');
            $table->timestamp('last_contact')->nullable()->after('tags');
            $table->integer('total_orders')->default(0)->after('last_contact');
            $table->decimal('total_spent', 15, 2)->default(0)->after('total_orders');
            $table->string('avatar')->nullable()->after('total_spent');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn([
                'mobile', 'company', 'website', 'city', 'state', 'postal_code',
                'country', 'tax_id', 'customer_type', 'status', 'credit_limit',
                'payment_terms', 'tags', 'last_contact', 'total_orders',
                'total_spent', 'avatar'
            ]);
        });
    }
};