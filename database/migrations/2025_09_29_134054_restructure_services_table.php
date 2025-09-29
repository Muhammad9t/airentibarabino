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
        Schema::table('services', function (Blueprint $table) {
            // Add new columns for hierarchical structure
            $table->string('type')->default('category')->after('slug'); // category, title, point
            $table->unsignedBigInteger('parent_id')->nullable()->after('type'); // For parent-child relationship
            $table->integer('sort_order')->default(0)->after('parent_id'); // For ordering
            $table->boolean('is_expanded')->default(false)->after('sort_order'); // For frontend accordion state
            
            // Add foreign key constraint
            $table->foreign('parent_id')->references('id')->on('services')->onDelete('cascade');
            
            // Add index for better performance
            $table->index(['type', 'parent_id', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropIndex(['type', 'parent_id', 'sort_order']);
            $table->dropColumn(['type', 'parent_id', 'sort_order', 'is_expanded']);
        });
    }
};