<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('student_finances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('course_id')->nullable(); // Si lié à un cours
            $table->string('type'); // ex: frais_general, voyage, cours, cafet, labo, etc
            $table->decimal('montant', 12, 2)->default(0);
            $table->string('status')->default('pending'); // paid, pending, overdue, etc
            $table->text('description')->nullable();
            $table->json('extra')->nullable(); // Pour flexibilité future (clé/valeur)
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('student_finances');
    }
};
