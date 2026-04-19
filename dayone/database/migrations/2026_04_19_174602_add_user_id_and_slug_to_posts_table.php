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
        Schema::table('posts', function (Blueprint $table) {
            // Add foreign key constraint only if user_id exists without constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            // Add slug column
            if (!Schema::hasColumn('posts', 'slug')) {
                $table->string('slug')->unique()->after('user_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id', 'slug']);
        });
    }
};
