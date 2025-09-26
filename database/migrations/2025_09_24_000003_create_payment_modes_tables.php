<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payment_modes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // A, B, C, ...
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('payment_mode_installments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_mode_id')->constrained('payment_modes')->cascadeOnDelete();
            $table->unsignedTinyInteger('sequence')->default(1);
            $table->decimal('percentage', 5, 2)->default(0); // 50.00 for 50%
            $table->integer('days_after')->default(0); // days after contract/choice to be due
            $table->string('label')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payment_mode_installments');
        Schema::dropIfExists('payment_modes');
    }
};
