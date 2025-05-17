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
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->text('description');
            $table->integer('quantity')->default(0);
            $table->decimal('price_php', 8, 2);
            $table->string('category')->nullable()->index();
            $table->string('unit_type')->default('each'); // e.g., each, box, dozen
            $table->integer('units_per_package')->default(1);
            $table->string('status')->nullable(); // Add status for inventory (e.g., damaged)
            $table->text('return_reason')->nullable(); // Add return reason (if any)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_items');
    }
};
