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
        Schema::table('inventory_actions', function (Blueprint $table) {
               $table->integer('quantity')->default(0); // Set default to avoid error
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventory_actions', function (Blueprint $table) {
             $table->dropColumn('quantity');
        });
    }
};
