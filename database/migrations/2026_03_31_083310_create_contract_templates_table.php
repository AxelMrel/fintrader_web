<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contract_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('entry_fees', 10, 2)->default(20000);
            $table->integer('duration_months')->default(6);
            $table->decimal('investor_share', 5, 2)->default(50);
            $table->decimal('manager_share', 5, 2)->default(50);
            $table->decimal('early_withdrawal_penalty', 5, 2)->default(30);
            $table->decimal('capital_protection', 5, 2)->default(50);
            $table->decimal('min_capital', 15, 2)->default(0);
            $table->decimal('max_capital', 15, 2)->nullable();
            $table->string('currency')->default('USD');
            $table->boolean('is_active')->default(true);
            $table->text('terms')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contract_templates');
    }
};