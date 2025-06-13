<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExtendedNewsTable extends Migration
{
    public function up()
    {
        Schema::create('extended_news', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('news_id');
            $table->text('content');
            $table->json('tags')->nullable();
            $table->timestamps();

            $table->foreign('news_id')->references('id')->on('news')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('extended_news');
    }
}
