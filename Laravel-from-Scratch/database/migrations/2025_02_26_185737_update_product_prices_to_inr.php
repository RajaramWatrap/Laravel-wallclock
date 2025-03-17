<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Convert existing prices from USD to INR (assuming exchange rate 1 USD = 83 INR)
        DB::statement('UPDATE products SET price = price * 20');
    }

    public function down(): void
    {
        // Revert prices back to USD
        DB::statement('UPDATE products SET price = price / 20');
    }
};
