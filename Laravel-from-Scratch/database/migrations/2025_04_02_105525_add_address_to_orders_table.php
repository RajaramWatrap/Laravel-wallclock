<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Step 1: Add the column as nullable
            $table->string('address')->nullable()->after('status');
        });

        // Step 2: Fill existing orders with a default address
        \DB::table('orders')->update(['address' => 'Default Address']);

        // Step 3: Make the column NOT NULL
        Schema::table('orders', function (Blueprint $table) {
            $table->string('address')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('address');
        });
    }
};

