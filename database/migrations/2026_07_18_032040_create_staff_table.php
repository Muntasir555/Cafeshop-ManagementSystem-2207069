<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')
                  ->nullable()
                  ->constrained('stores')
                  ->nullOnDelete();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone', 30)->nullable();
            $table->enum('role', ['barista', 'cashier', 'manager', 'supervisor', 'cleaner']);
            $table->enum('shift', ['morning', 'afternoon', 'evening', 'full_day']);
            $table->decimal('monthly_salary', 10, 2);
            $table->date('join_date');
            $table->enum('status', ['active', 'on_leave', 'terminated'])->default('active');
            $table->string('photo')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};

