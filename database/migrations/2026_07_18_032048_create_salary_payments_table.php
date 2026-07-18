<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('salary_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_id')->constrained('staff')->cascadeOnDelete();
            $table->decimal('amount', 10, 2);
            $table->string('payment_month', 7); // e.g. "2026-07"
            $table->date('payment_date');
            $table->enum('payment_method', ['cash', 'bank_transfer', 'mobile_banking']);
            $table->text('note')->nullable();
            $table->string('paid_by');
            $table->timestamps();

            // Prevent paying the same staff member twice in the same month
            $table->unique(['staff_id', 'payment_month']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('salary_payments');
    }
};

