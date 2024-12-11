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
        Schema::create('finance_accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->string('name');
            $table->string('type');
            $table->decimal('balance', 10, 3)->default(0)->comment('余额');
            $table->decimal('credit_limit', 10, 3)->default(0)->comment('信用卡限额');
            $table->tinyInteger('settlement_day')->nullable()->comment('信用卡出账日');
            $table->boolean('status')->default(true)->comment('是否可用');
            $table->string('notes')->nullable()->comment('备注');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('finance_accounts');
    }
};
