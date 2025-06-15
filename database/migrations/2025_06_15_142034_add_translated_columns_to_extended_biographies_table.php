<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTranslatedColumnsToExtendedBiographiesTable extends Migration
{
    public function up()
    {
        Schema::table('extended_biographies', function (Blueprint $table) {
            $table->text('biography_translated')->nullable()->after('biography');
            $table->string('university_translated')->nullable()->after('university');
            $table->text('experience_translated')->nullable()->after('experience');
            $table->json('skills_translated')->nullable()->after('skills');
        });
    }

    public function down()
    {
        Schema::table('extended_biographies', function (Blueprint $table) {
            $table->dropColumn([
                'biography_translated',
                'university_translated',
                'experience_translated',
                'skills_translated',
            ]);
        });
    }
}
