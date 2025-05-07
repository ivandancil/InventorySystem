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
        Schema::table('inventory_items', function (Blueprint $table) {
            if (!Schema::hasColumn('inventory_items', 'restocked')) {
                $table->boolean('restocked')->default(false);
            }
            if (!Schema::hasColumn('inventory_items', 'needs_update')) {
                $table->boolean('needs_update')->default(false);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventory_items', function (Blueprint $table) {
            if (Schema::hasColumn('inventory_items', 'restocked')) {
                $table->dropColumn('restocked');
            }
            if (Schema::hasColumn('inventory_items', 'needs_update')) {
                $table->dropColumn('needs_update');
            }
        });
    }
};
