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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('teacher_id')->nullable(); // 1. Déclare la colonne nullable
            $table->unsignedBigInteger('mention_id')->nullable(); // Ajoute la clé étrangère mention_id
            $table->string('sigle')->unique();
            $table->string('nom');
            $table->integer('credits');
            $table->timestamps();
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('set null'); 
            $table->foreign('mention_id')->references('id')->on('mentions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};