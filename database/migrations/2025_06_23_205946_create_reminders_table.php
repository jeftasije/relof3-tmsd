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
        Schema::create('reminders', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('category_en', [
                'news', 
                'procurements', 
                'Statute', 
                'Founding Acts', 
                'Annual Plans',
                'Activity Reports', 
                'Management Body Reports', 
                'Information Book', 
                'Director Election Procedure', 
                'Other Acts Regulating Ethics and Integrity'])->nullable();
            $table->enum('category_cyr', [
                'вести',
                'јавне набавке',
                'Статут',
                'Оснивачки акти',
                'Годишњи планови',
                'Извештаји о раду',
                'Извештаји управљачких тела',
                'Информатор о раду',
                'Поступак избора директора',
                'Остали акти који уређују етику и интегритет'])->nullable();
            $table->enum('category_lat', [
                'vesti',
                'javne nabavke',
                'Statut',
                'Osnivački akti',
                'Godišnji planovi',
                'Izveštaji o radu',
                'Izveštaji upravljačkih tela',
                'Informator o radu',
                'Postupak izbora direktora',
                'Ostali akti koji uređuju etiku i integritet'])->nullable();
            $table->string('custom_category')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reminders');
    }
};
