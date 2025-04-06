<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, let's check if we need to update the field
        $columns = DB::select("SHOW COLUMNS FROM orders WHERE Field = 'status'");
        if (count($columns) > 0) {
            $currentType = $columns[0]->Type;
            
            // Only update if the current type doesn't include all our required statuses
            if (!str_contains($currentType, 'in_transit')) {
                // We need to alter the enum to include all necessary statuses
                DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('processing', 'shipped', 'in_transit', 'delivered', 'cancelled') NOT NULL DEFAULT 'processing'");
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // We won't revert back to avoid losing data
    }
};
