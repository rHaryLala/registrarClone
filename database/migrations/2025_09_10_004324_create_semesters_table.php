<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('semesters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('academic_year_id')->nullable();
            $table->foreign('academic_year_id')->references('id')->on('academic_years')->onDelete('set null');
            $table->string('nom'); // Premier semestre, Semestre d'été, etc.
            $table->unsignedTinyInteger('ordre'); // 1 à 4
            $table->year('annee')->nullable(); // Optionnel : année académique
            $table->date('date_debut')->nullable();
            $table->date('date_fin')->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('semesters');
    }
};
