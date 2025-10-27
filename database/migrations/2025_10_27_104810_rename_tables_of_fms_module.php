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
        Schema::rename('finance_transactions', 'fms_transactions');
        Schema::rename('finance_settings', 'fms_settings');
        Schema::rename('finance_currencies', 'fms_currencies');
        Schema::rename('finance_accounts', 'fms_accounts');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('fms_transactions', 'finance_transactions');
        Schema::rename('fms_settings', 'finance_settings');
        Schema::rename('fms_currencies', 'finance_currencies');
        Schema::rename('fms_accounts', 'finance_accounts');
    }
};
