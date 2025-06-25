<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('gallery_descriptions', function (Blueprint $table) {
            $table->text('value_en')->nullable()->after('value');
            $table->text('value_cy')->nullable()->after('value_en');
        });
    }

    public function down(): void
    {
        Schema::table('gallery_descriptions', function (Blueprint $table) {
            $table->dropColumn(['value_en', 'value_cy']);
        });
    }
};
