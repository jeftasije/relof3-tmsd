<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('navigations', function (Blueprint $table) {
            $table->string('name_cy')->nullable()->after('name_en');
        });
    }

    public function down(): void
    {
        Schema::table('navigations', function (Blueprint $table) {
            $table->dropColumn('name_cy');
        });
    }
};