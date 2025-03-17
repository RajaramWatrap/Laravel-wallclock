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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description', 1000);
            $table->decimal('price', 10, 2); // ✅ Fixed: Using decimal for price
            $table->unsignedInteger('stock'); // ✅ Fixed: Correct way to set unsigned
            $table->enum('status', ['available', 'unavailable'])->default('unavailable'); // ✅ Fixed: Enum for better status handling
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

