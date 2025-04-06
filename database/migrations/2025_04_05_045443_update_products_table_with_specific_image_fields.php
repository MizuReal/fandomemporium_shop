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
        Schema::table('products', function (Blueprint $table) {
            // Add 5 specific image fields
            $table->string('main_image')->nullable()->after('additional_information');
            $table->string('image1')->nullable()->after('main_image');
            $table->string('image2')->nullable()->after('image1');
            $table->string('image3')->nullable()->after('image2');
            $table->string('image4')->nullable()->after('image3');
            
            // Drop the multiple_images field
            $table->dropColumn('multiple_images');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Re-add the multiple_images field
            $table->text('multiple_images')->nullable()->after('additional_information');
            
            // Drop the specific image fields
            $table->dropColumn('main_image');
            $table->dropColumn('image1');
            $table->dropColumn('image2');
            $table->dropColumn('image3'); 
            $table->dropColumn('image4');
        });
    }
};
