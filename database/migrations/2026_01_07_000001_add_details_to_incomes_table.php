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
        Schema::table('incomes', function (Blueprint $table) {
            if (!Schema::hasColumn('incomes', 'category_id')) {
                $table->foreignId('category_id')->nullable()->after('user_id')->constrained()->nullOnDelete();
            }
            if (!Schema::hasColumn('incomes', 'pcb_amount')) {
                $table->decimal('pcb_amount', 12, 2)->nullable()->after('amount');
            }
            if (!Schema::hasColumn('incomes', 'attachment')) {
                $table->string('attachment')->nullable()->after('notes');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('incomes', function (Blueprint $table) {
            $table->dropColumn(['category_id', 'pcb_amount', 'attachment']);
        });
    }
};