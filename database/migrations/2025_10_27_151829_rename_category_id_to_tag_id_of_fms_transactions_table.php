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
        Schema::table('fms_transactions', function (Blueprint $table) {
            $table->renameColumn('category_id', 'tag_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fms_transactions', function (Blueprint $table) {
            $table->renameColumn('tag_id', 'category_id');
        });
    }
};
