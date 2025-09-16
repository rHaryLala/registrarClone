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
            $table->unsignedBigInteger('teacher_id')->nullable();
            $table->unsignedBigInteger('mention_id')->nullable(); 
            $table->string('sigle')->unique();
            $table->string('nom');
            $table->integer('credits');
            $table->unsignedBigInteger('year_level_id')->nullable();
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('set null'); 
            $table->foreign('mention_id')->references('id')->on('mentions')->onDelete('cascade');
            $table->foreign('year_level_id')->references('id')->on('year_levels')->onDelete('set null');
            $table->boolean('besoin_labo')->default(false);
            $table->timestamps();
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