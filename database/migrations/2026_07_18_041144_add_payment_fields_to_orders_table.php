<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('stripe_session_id')->nullable()->after('notes');
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending')->after('stripe_session_id');
            $table->string('payment_method')->nullable()->after('payment_status');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['stripe_session_id', 'payment_status', 'payment_method']);
        });
    }
};

