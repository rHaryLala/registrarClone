<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('year_levels', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // ex: L1, L2, L3, M1, M2
            $table->string('label'); // ex: Licence 1, Master 1, etc.
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('year_levels');
    }
};
