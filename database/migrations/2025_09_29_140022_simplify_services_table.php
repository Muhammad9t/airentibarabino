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
            // Remove the hierarchical columns we added before
            $table->dropForeign(['parent_id']);
            $table->dropIndex(['type', 'parent_id', 'sort_order']);
            $table->dropColumn(['type', 'parent_id', 'sort_order', 'is_expanded']);
            
            // Add simple menu order column
            $table->integer('menu_order')->default(0)->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('menu_order');
            
            // Re-add the hierarchical columns
            $table->string('type')->default('category')->after('slug');
            $table->unsignedBigInteger('parent_id')->nullable()->after('type');
            $table->integer('sort_order')->default(0)->after('parent_id');
            $table->boolean('is_expanded')->default(false)->after('sort_order');
            
            $table->foreign('parent_id')->references('id')->on('services')->onDelete('cascade');
            $table->index(['type', 'parent_id', 'sort_order']);
        });
    }
};