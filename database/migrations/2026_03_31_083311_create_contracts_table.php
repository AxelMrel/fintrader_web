<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('contract_template_id')->constrained()->onDelete('cascade');
            $table->decimal('capital', 15, 2);
            $table->string('currency')->default('USD');
            $table->decimal('entry_fees', 10, 2);
            $table->decimal('investor_share', 5, 2);
            $table->decimal('manager_share', 5, 2);
            $table->decimal('early_withdrawal_penalty', 5, 2);
            $table->decimal('capital_protection', 5, 2);
            $table->integer('duration_months');
            $table->enum('status', ['pending', 'active', 'closed', 'cancelled'])->default('pending');
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->decimal('current_capital', 15, 2)->nullable();
            $table->decimal('profit_loss', 15, 2)->default(0);
            $table->boolean('client_accepted')->default(false);
            $table->timestamp('accepted_at')->nullable();
            $table->string('pdf_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};