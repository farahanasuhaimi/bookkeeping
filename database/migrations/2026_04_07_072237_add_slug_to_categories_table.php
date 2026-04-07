<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('name');
        });

        // Backfill slugs for existing seeded system categories
        $slugs = [
            1  => 'employment-income',
            2  => 'part-time-business',
            5  => 'lifestyle',
            12 => 'epf-contribution',
            13 => 'zakat',
            14 => 'life-insurance',
            15 => 'medical-insurance',
            16 => 'sspn-savings',
            17 => 'prs-retirement',
            18 => 'rental-income',
            19 => 'dividends-interest',
        ];

        foreach ($slugs as $id => $slug) {
            DB::table('categories')->where('id', $id)->update(['slug' => $slug]);
        }
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
