<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTranslationsToExtendedNewsTable extends Migration
{
    public function up()
    {
        Schema::table('extended_news', function (Blueprint $table) {
            $table->text('content_en')->nullable()->after('content');
            $table->json('tags_en')->nullable()->after('tags');
        });
    }

    public function down()
    {
        Schema::table('extended_news', function (Blueprint $table) {
            $table->dropColumn(['content_en', 'tags_en']);
        });
    }
}
