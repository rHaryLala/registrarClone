<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('finance', function (Blueprint $table) {
            $table->id();
            $table->string('student_id', 50)->nullable()->comment('Matricule de l\'étudiant');
            $table->index('student_id');
            $table->unsignedBigInteger('semester_id')->nullable();
            $table->string('std_etude', 40)->nullable()->comment('Etude ou filière envisagé');
            $table->tinyInteger('residence')->default(0)->comment('Résidence: 0 - externe, 1 - interne');
            $table->tinyInteger('std_yearlevel')->default(1);
            $table->tinyInteger('semester')->default(1);
            $table->tinyInteger('new_student')->default(0);
            $table->tinyInteger('encadrement')->default(0);
            $table->tinyInteger('graduated')->default(0)->comment('Gradué: 0 - non, 1 - oui');
            $table->tinyInteger('total_credit')->default(1);
            $table->tinyInteger('lab_info')->default(0)->comment('if lab info exists');
            $table->tinyInteger('lab_langue')->default(0)->comment('if lab langue exists');
            $table->string('plan', 1)->default('E')->comment('Le plan choisi');
            $table->string('total_payment', 40)->default('0');
            $table->string('amount_pay_1', 50)->nullable();
            $table->string('amount_pay_2', 50)->nullable();
            $table->string('amount_pay_3', 50)->nullable();
            $table->string('amount_pay_4', 50)->nullable();
            $table->string('amount_pay_5', 50)->nullable();
            $table->string('date_payment_1', 255)->nullable();
            $table->string('date_payment_2', 255)->nullable();
            $table->string('date_payment_3', 255)->nullable();
            $table->string('date_payment_4', 255)->nullable();
            $table->string('date_payment_5', 255)->nullable();
            $table->tinyInteger('retard')->default(0);
            $table->dateTime('date_entry')->useCurrent();
            $table->unsignedBigInteger('last_change_user_id')->nullable();
            $table->dateTime('last_change_datetime')->useCurrent();
            $table->foreign('semester_id')->references('id')->on('semesters')->onDelete('set null');
            $table->foreign('student_id')->references('matricule')->on('students')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('finance');
    }
};
