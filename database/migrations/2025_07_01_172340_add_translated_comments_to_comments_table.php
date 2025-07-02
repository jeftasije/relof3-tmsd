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
        Schema::table('comments', function (Blueprint $table) {
            $table->text('comment_lat')->nullable()->after('comment');
            $table->text('comment_cy')->nullable()->after('comment_lat');
            $table->text('comment_en')->nullable()->after('comment_cy');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropColumn(['comment_lat', 'comment_cy', 'comment_en']);
        });
    }
};
