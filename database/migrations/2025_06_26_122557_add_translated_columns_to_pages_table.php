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
        Schema::table('pages', function (Blueprint $table) {
            $table->text('title_en')->nullable()->after('title');
            $table->text('title_cy')->nullable()->after('title');
            $table->text('content_en')->nullable()->after('content');
            $table->text('content_cy')->nullable()->after('content');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn(['title_en', 'title_cy', 'content_en', 'content_cy']);
        });
    }
};
