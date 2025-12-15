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
        Schema::create('fms_transactions', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->unsignedBigInteger('user_id')->comment('用户ID');
            $table->unsignedInteger('account_id')->nullable()->comment('财务账户ID');
            $table->string('type')->comment('类型：收入/支出');
            $table->date('date')->comment('日期');
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('tag_id')->nullable();
            $table->string('notes')->nullable()->comment('简短说明');
            $table->unsignedInteger('currency_id')->comment('货币');
            $table->decimal('amount', 10,3);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('finance_transactions');
    }
};
