<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('account_codes', function (Blueprint $table) {
            $table->string('account_code')->primary();
            $table->string('matricule')->nullable()->index(); // Permettre les matricules null temporairement
            $table->timestamps();
            // On retire temporairement la contrainte de clé étrangère
            // $table->foreign('matricule')->references('matricule')->on('students')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('account_codes');
    }
};
