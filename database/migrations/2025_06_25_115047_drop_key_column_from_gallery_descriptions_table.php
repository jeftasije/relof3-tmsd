<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('gallery_descriptions', function (Blueprint $table) {
            $table->dropUnique('gallery_descriptions_key_unique');
            $table->dropColumn('key');
        });
    }

    public function down(): void
    {
        Schema::table('gallery_descriptions', function (Blueprint $table) {
            $table->string('key')->unique()->after('id');
        });
    }
};
