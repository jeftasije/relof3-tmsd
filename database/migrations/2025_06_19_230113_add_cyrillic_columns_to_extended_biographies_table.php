<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCyrillicColumnsToExtendedBiographiesTable extends Migration
{
    public function up()
    {
        Schema::table('extended_biographies', function (Blueprint $table) {
            $table->text('biography_cy')->nullable()->after('biography_translated');
            $table->string('university_cy')->nullable()->after('university_translated');
            $table->text('experience_cy')->nullable()->after('experience_translated');
            $table->json('skills_cy')->nullable()->after('skills_translated');
        });
    }

    public function down()
    {
        Schema::table('extended_biographies', function (Blueprint $table) {
            $table->dropColumn([
                'biography_cy',
                'university_cy',
                'experience_cy',
                'skills_cy',
            ]);
        });
    }
}
