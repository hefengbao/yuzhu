<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fms_currencies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 3)->comment('货币标识');
            $table->string('symbol')->nullable()->comment('货币符号');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('finance_currencies');
    }
};
