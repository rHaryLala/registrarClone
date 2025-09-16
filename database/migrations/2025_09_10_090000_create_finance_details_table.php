<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('finance_details', function (Blueprint $table) {
            $table->id();
            $table->string('statut_etudiant'); // interne, externe, bungalow, etc.
            $table->unsignedBigInteger('mention_id')->nullable();
            $table->foreign('mention_id')->references('id')->on('mentions')->onDelete('set null');
            $table->decimal('frais_generaux', 12, 2)->default(0);
            $table->decimal('ecolage', 12, 2)->default(0);
            $table->decimal('laboratory', 12, 2)->default(0);
            $table->decimal('dortoir', 12, 2)->default(0);
            $table->integer('nb_jours_semestre')->nullable();
            $table->integer('nb_jours_semestre_L2')->nullable();
            $table->integer('nb_jours_semestre_L3')->nullable();
            $table->decimal('cafeteria', 12, 2)->default(0);
            $table->decimal('fond_depot', 12, 2)->default(0);
            $table->decimal('frais_graduation', 12, 2)->default(0);
            $table->decimal('frais_costume', 12, 2)->default(0);
            $table->decimal('frais_voyage', 12, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('finance_details');
    }
};
