<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('signals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trader_id')->constrained('users')->onDelete('cascade');
            $table->string('pair');
            $table->enum('direction', ['buy', 'sell']);
            $table->decimal('entry_price', 10, 5);
            $table->decimal('take_profit', 10, 5);
            $table->decimal('stop_loss', 10, 5);
            $table->text('description')->nullable();
            $table->enum('status', ['active', 'closed', 'cancelled'])->default('active');
            $table->enum('result', ['tp_hit', 'sl_hit', 'cancelled'])->nullable();
            $table->enum('plan_required', ['basic', 'premium', 'vip'])->default('basic');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('signals');
    }
};