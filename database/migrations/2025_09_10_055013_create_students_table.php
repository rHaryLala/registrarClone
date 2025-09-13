<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('matricule')->unique();
            $table->string('image')->nullable(); 
            
            // Informations personnelles
            $table->string('nom');
            $table->string('prenom');
            $table->enum('sexe', ['M', 'F']);
            $table->date('date_naissance');
            $table->string('lieu_naissance');
            $table->string('nationalite')->default('Malagasy');
            $table->string('religion')->nullable()->default('Adventiste du 7ème jour');
            $table->enum('etat_civil', ['célibataire', 'marié', 'divorcé', 'veuf']);
            
            // Informations passeport (optionnelles)
            $table->boolean('passport_status')->default(false);
            $table->string('passport_numero')->nullable();
            $table->string('passport_pays_emission')->nullable();
            $table->date('passport_date_emission')->nullable();
            $table->date('passport_date_expiration')->nullable();
            
            // Informations conjoint (conditionnelles)
            $table->string('nom_conjoint')->nullable();
            $table->integer('nb_enfant')->default(0);
            
            // Informations CIN (conditionnelles)
            $table->string('cin_numero')->nullable();
            $table->date('cin_date_delivrance')->nullable();
            $table->string('cin_lieu_delivrance')->nullable();
            
            // Informations parents
            $table->string('nom_pere');
            $table->string('profession_pere');
            $table->string('contact_pere');
            $table->string('nom_mere');
            $table->string('profession_mere');
            $table->string('contact_mere');
            $table->text('adresse_parents');
            
            // Coordonnées
            $table->string('telephone')->nullable();
            $table->string('email')->unique();
            $table->text('adresse');
            $table->string('region');
            $table->string('district');
            
            // Scolarité
            $table->string('bacc_serie')->nullable();
            $table->date('bacc_date_obtention')->nullable();
            $table->boolean('bursary_status')->default(false);
            
            // Informations sponsor (conditionnelles)
            $table->string('sponsor_nom')->nullable();
            $table->string('sponsor_prenom')->nullable();
            $table->string('sponsor_telephone')->nullable();
            $table->text('sponsor_adresse')->nullable();
            
            // Informations académiques
            $table->enum('annee_etude', ['L1', 'L2', 'L3', 'M1', 'M2']);
            $table->unsignedBigInteger('mention_id')->nullable();
            $table->foreign('mention_id')->references('id')->on('mentions')->onDelete('set null');
            $table->unsignedBigInteger('semester_id')->nullable();
            $table->foreign('semester_id')->references('id')->on('semesters')->onDelete('set null');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('students');
    }
};