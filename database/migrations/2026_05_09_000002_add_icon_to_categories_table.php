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
            $table->string('icon', 50)->default('bi-tag')->after('description');
        });

        DB::table('categories')->where('slug', 'electronics')->update([
            'icon' => 'bi-phone',
        ]);

        DB::table('categories')->where('slug', 'decor')->update([
            'icon' => 'bi-stars',
        ]);

        DB::table('categories')->where('slug', 'kitchen')->update([
            'icon' => 'bi-cup-hot',
        ]);
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('icon');
        });
    }
};