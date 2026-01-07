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
        // Add missing columns to expenses table
        if (!Schema::hasColumn('expenses', 'is_deductible')) {
            Schema::table('expenses', function (Blueprint $table) {
                $table->boolean('is_deductible')->default(false)->after('receipt_url');
                $table->text('notes')->nullable()->after('is_deductible');
            });
        }

        // Add missing columns to incomes table
        if (!Schema::hasColumn('incomes', 'notes')) {
            Schema::table('incomes', function (Blueprint $table) {
                $table->text('notes')->nullable()->after('status');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('expenses', 'is_deductible')) {
            Schema::table('expenses', function (Blueprint $table) {
                $table->dropColumn(['is_deductible', 'notes']);
            });
        }

        if (Schema::hasColumn('incomes', 'notes')) {
            Schema::table('incomes', function (Blueprint $table) {
                $table->dropColumn('notes');
            });
        }
    }
};
