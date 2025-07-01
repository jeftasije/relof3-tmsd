<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->text('subject_en')->nullable()->after('subject');
            $table->text('subject_cy')->nullable()->after('subject_en');
            $table->text('message_en')->nullable()->after('message');
            $table->text('message_cy')->nullable()->after('message_en');
        });
    }

    public function down(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->dropColumn(['subject_en', 'subject_cy', 'message_en', 'message_cy']);
        });
    }
};
