<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('student_semester_fees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('academic_year_id')->constrained('academic_years')->cascadeOnDelete();
            $table->foreignId('semester_id')->constrained('semesters')->cascadeOnDelete();

            // Breakdown columns
            $table->decimal('frais_generaux', 12, 2)->default(0);
            $table->decimal('dortoir', 12, 2)->default(0);
            $table->decimal('cantine', 12, 2)->default(0);
            $table->decimal('labo_info', 12, 2)->default(0);
            $table->decimal('labo_comm', 12, 2)->default(0);
            $table->decimal('labo_langue', 12, 2)->default(0);
            $table->decimal('ecolage', 12, 2)->default(0);
            $table->decimal('voyage_etude', 12, 2)->default(0);
            $table->decimal('colloque', 12, 2)->default(0);
            $table->decimal('frais_costume', 12, 2)->default(0);

            // total cached amount
            $table->decimal('total_amount', 14, 2)->default(0);

            // meta: who/when computed
            $table->unsignedBigInteger('computed_by_user_id')->nullable();
            $table->timestamp('computed_at')->nullable();

            $table->timestamps();

            $table->unique(['student_id','academic_year_id','semester_id'], 'student_semester_unique');
        });
    }

    public function down()
    {
        Schema::dropIfExists('student_semester_fees');
    }
};
