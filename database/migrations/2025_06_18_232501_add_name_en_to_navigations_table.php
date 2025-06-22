<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNameEnToNavigationsTable extends Migration
{
    public function up()
    {
        Schema::table('navigations', function (Blueprint $table) {
            $table->string('name_en')->nullable()->after('name');
        });
    }

    public function down()
    {
        Schema::table('navigations', function (Blueprint $table) {
            $table->dropColumn('name_en');
        });
    }
}
