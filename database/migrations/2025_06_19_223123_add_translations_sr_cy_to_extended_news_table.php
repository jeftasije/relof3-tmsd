<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('extended_news', function (Blueprint $table) {
            $table->text('content_cy')->nullable()->after('content_en');
            $table->json('tags_cy')->nullable()->after('tags_en');
        });
    }

    public function down(): void
    {
        Schema::table('extended_news', function (Blueprint $table) {
            $table->dropColumn(['content_cy', 'tags_cy']);
        });
    }
};